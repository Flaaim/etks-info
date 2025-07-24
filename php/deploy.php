<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config
set('application', 'etks-info');
set('git_ssh_command', 'ssh -o StrictHostKeyChecking=no -i ~/.ssh/id_rsa');
set('repository', 'https://github.com/Flaaim/etks-info-prod.git');
set('php_version', '8.1');
set('bin/php', '/opt/php/8.1/bin/php');
set('writable_mode', 'chmod');

host('production')
    ->set('hostname', '31.31.198.114')
    ->set('port', 22)
    ->set('remote_user', 'u1656040')
    ->set('deploy_path', '~/www/etks-info')
    ->set('public_path', '{{deploy_path}}/public')
    ->set('branch', 'master');


add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

task('deploy:symlink', function () {
    run("cd {{deploy_path}} && ln -sfn {{release_path}} public");

});

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:publish'
]);

after('deploy:failed', 'deploy:unlock');
