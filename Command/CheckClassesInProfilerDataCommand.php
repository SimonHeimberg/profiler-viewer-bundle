<?php

namespace SimonHeimberg\ProfilerViewerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Process\Process;

/**
 * Check classes in profiler data file.
 *
 * @author Simon Heimberg <simon.heimberg@heimberg-ea.ch>
 **/
class CheckClassesInProfilerDataCommand extends Command
{
    protected static $defaultName = 'profiler-viewer:check-classes';

    protected function configure()
    {
        $cmdName = static::$defaultName;
        $this
            ->setDescription('List unloadable classes from profiler data')
            ->setHelp(<<<EOMsg
Check if classes from profiler data are loadable, and list the unloadable ones.

Only classes required to load are checked. This are mainly the classes implementing Serializable interface.

example call: bin/console $cmdName some/project/var/cache/prod/profiler/02/b1/18b102
EOMsg
            )
            ->addArgument('profiler_data_file', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profilerDataFile = $input->getArgument('profiler_data_file');

        $failed = 0;
        foreach ($this->getClasses($profilerDataFile) as $toTest) {
            if ($toTest) {
                if (!$this->testClass($toTest, $output)) {
                    ++$failed;
                }
            }
        }

        if ($failed > 0) {
            return 7;
        } else {
            $output->writeln('all classes loadable');

            return 0;
        }
    }

    private function testClass($toTest, OutputInterface $output)
    {
        $loadable = false;
        try {
            new $toTest();
            $loadable = true;
        } catch (\ArgumentCountError $e) {
            $loadable = true; // ignore failure
        } catch (\Error $e) {
            $msg = $e->getMessage();
            if ((false !== strpos($msg, 'Class ') || false !== strpos($msg, 'Interface ')) && false !== strpos($msg, ' not found')) {
                $missingClassName = strtr($msg, [
                    'Class' => '',
                    'Interface' => '',
                    'not found' => '',
                    ' ' => '',
                    "'" => '',
                    '"' => '',
                    '\\' => '/',
                ]);
                $output->writeln("$msg, place it in\n   external_src/$missingClassName.php");
            } else {
                throw $e;
            }
        }

        return $loadable;
    }

    private function getClasses($profilerDataFile)
    {
        $c = file_get_contents($profilerDataFile, false, null, 0, 1); // read one character
        if (!$c) {
            throw new IOException("can not read file $profilerDataFile");
        }

        $cmd1 = <<<EOsh1
zgrep --text -o 'C:[0-9]*:"[^"]*"' '$profilerDataFile' | \n
EOsh1;
        $cmd2 = <<<'EOsh2'
            sort -u |
            sed -s -e 's%^[^"]*"%%' -e 's%"$%%'
EOsh2;
        $proc = Process::fromShellCommandLine($cmd1.$cmd2);
        $proc->mustRun();

        return explode("\n", $proc->getOutput());
    }
}
