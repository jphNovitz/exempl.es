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
    private string $path = '/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->siteRepository = $this->manager->getRepository(Site::class);
    }

    public function test_site_index_page_is_accessible(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/tag.yaml',
            'fixtures/test/category.yaml',
            'fixtures/test/site.yaml'
        ]);

        $sites = $this->siteRepository->findAll();

        $this->client->request('GET', $this->path);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
//        $this->assertSelectorTextContains("H1", "Liste des sites");
    }
    public function test_site_show_page(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/tag.yaml',
            'fixtures/test/category.yaml',
            'fixtures/test/site.yaml'
        ]);

        $site = $this->siteRepository->findAll()[0];

        $crawler = $this->client->request('GET', sprintf('%s%s%s', $this->path, 'site/',  $site->getSlug()));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertStringContainsStringIgnoringCase($site->getTitle(), $crawler->text());
    }

}