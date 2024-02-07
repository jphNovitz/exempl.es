<?php

namespace App\Tests\Controller;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;
    private TagRepository $tagRepository;
    private SiteRepository $siteRepository;
    private string $path = '/admin/site/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->siteRepository = $this->manager->getRepository(Site::class);
    }
}