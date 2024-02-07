<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Category;
use App\Entity\Site;
use App\Entity\Tag;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\SiteRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
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
        $this->userRepository = $this->manager->getRepository(User::class);
        $this->siteRepository = $this->manager->getRepository(Site::class);
        $this->categoryRepository = $this->manager->getRepository(Category::class);
        $this->tagRepository = $this->manager->getRepository(Tag::class);
    }

    public function test_site_admin_page_index_is_not_accessible_anonymously(): void
    {
        $this->client->request('GET', $this->path);

        $this->assertResponseRedirects();
        $this->assertResponseRedirects('/login');

    }

    public function test_site_admin_page_actions_is_accessible_for_logged_admin(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/user.yaml'
        ]);
        $user = $this->userRepository->findAll()[0];

        $this->client->loginUser($user);
        $this->client->request('GET', $this->path);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains("H1", "Liste des sites");
    }

    public function test_site_admin_show(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/user.yaml',
            'fixtures/test/category.yaml',
            'fixtures/test/tag.yaml',
            'fixtures/test/site.yaml'
        ]);
        $user = $this->userRepository->findAll()[0];
        $site = $this->siteRepository->findAll()[0];

        $this->client->loginUser($user);
        $this->client->request('GET', $this->path);

        $response = $this->client->request('GET', sprintf('%s%s', $this->path, $site->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Site');
        self::assertPageTitleContains($site->getTitle());
        self::assertStringContainsString($site->getTitle(), $response->text());
    }

    public function test_site_admin_new(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/user.yaml',
            'fixtures/test/category.yaml',
            'fixtures/test/tag.yaml',
        ]);


        $user = $this->userRepository->findAll()[0];
        $this->client->loginUser($user);

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'site[title]' => 'Testing',
            'site[description]' => 'Testing',
            'site[image]' => 'Testing',
            'site[repo]' => 'Testing',
            'site[categories]' => [1],
            'site[tags]' => [1],
        ]);

        self::assertResponseRedirects('/admin/site/');

        self::assertSame(1, $this->siteRepository->count([]));
    }


//
    public function test_site_admin_edit(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/user.yaml',
            'fixtures/test/category.yaml',
            'fixtures/test/tag.yaml',
        ]);


        $user = $this->userRepository->findAll()[0];
        $this->client->loginUser($user);

        $fixture = new Site();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setImage('Value');
        $fixture->setRepo('Value');
        $fixture->addCategory($this->categoryRepository->findAll()[1]);
        $fixture->addTag($this->tagRepository->findAll()[0]);
        $this->manager->persist($fixture);
        $this->manager->flush();

        $crawler = $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
//
//        $form = $crawler->selectButton('Update')->form();
////        dd($form['site[categories][1]']-);
//        $form['site[categories]'] = [1=>'2', 2=>'3'];

        $this->client->submitForm('Update', [
            'site[title]' => 'Something New',
            'site[description]' => 'Something New',
            'site[image]' => 'Something New',
            'site[repo]' => 'Something New',
            'site[categories]' => [1=>'2', 2=>'3'],
            'site[tags]' => [1, 2],
        ]);

        self::assertResponseRedirects('/admin/site/');

        $site = $this->siteRepository->findAll()[0];

        $category_ids = array_map(function ($category) {
            return $category->getId();
        }, iterator_to_array($site->getCategories()));

        $tag_ids = array_map(function ($tag) {
            return $tag->getId();
        }, iterator_to_array($site->getTags()));

        self::assertSame('Something New', $site->getTitle());
        self::assertSame('Something New', $site->getDescription());
        self::assertSame('Something New', $site->getImage());
        self::assertSame('Something New', $site->getRepo());
        self::assertContains(2, $category_ids);
        self::assertContains(2, $tag_ids);
    }

    public function test_site_admin_remove(): void
    {
        $this->databaseTool->loadAliceFixture([
            'fixtures/test/user.yaml',
            'fixtures/test/category.yaml',
            'fixtures/test/tag.yaml',
            'fixtures/test/site.yaml',
        ]);

        $user = $this->userRepository->findAll()[0];
        $this->client->loginUser($user);

        $count_sites = $this->siteRepository->count([]);
        $expected_count = $count_sites-1;
        $site_to_remove = $this->siteRepository->findAll()[0];
        $this->client->request('GET', sprintf('%s%s', $this->path, $site_to_remove->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/admin/site/');
        self::assertSame($expected_count, $this->siteRepository->count([]));
    }
}
