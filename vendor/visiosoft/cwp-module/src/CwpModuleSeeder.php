<?php namespace Visiosoft\CwpModule;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;

class CwpModuleSeeder extends Seeder
{
    protected $repository;

    public function __construct(ServerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        //Create Demo Server
        $this->repository->create([
            'name' => 'Demo Server',
            'node_name' => 'ocifydemo',
            'api_key' => '794LCgN3lgRn4jCZiK2Ly3qA2IUHQM0Ghkv1Qvv6qaSs4',
            'api_url' => 'https://demoserver.visiosoft.com.tr:2304/v1/',
            'server_ip' => '3.21.32.10',
        ]);

        //Create Main Server
        $this->repository->create([
            'name' => 'Main Server',
            'node_name' => 'demo74',
            'api_key' => 'bBSfwKGo0Tt2Z0aoSHEQk8utnZFBNIJsbH9vIjexe734d',
            'api_url' => 'https://newserver.openclassify.com:2304/v1/',
            'server_ip' => '3.19.177.13',
        ]);
    }
}