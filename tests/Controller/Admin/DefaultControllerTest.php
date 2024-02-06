<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityRepository $repository;
    private string $path = '/admin';
    private $databaseTool;


    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->repository = static::getContainer()->get('doctrine')->getManager()->getRepository(User::class);
    }


    public function test_default_admin_is_not_accessible_anonymously(): void
    {
        $this->client->request('GET', $this->path);

        $this->assertResponseRedirects();
        $this->assertResponseRedirects('/login');

    }

    public function test_default_admin_is_accessible_for_logged_admin(): void
    {
        $this->databaseTool->loadAliceFixture(['fixtures/test/user.yaml']);
        $user = $this->repository->findAll()[0];

        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', '/admin/');
        $this->assertResponseIsSuccessful();
    }

}
