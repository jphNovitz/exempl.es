<?php

namespace App\Test\Controller;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/admin/site/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Site::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Site index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'site[title]' => 'Testing',
            'site[description]' => 'Testing',
            'site[image]' => 'Testing',
            'site[repo]' => 'Testing',
            'site[categories]' => 'Testing',
            'site[tags]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Site();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImage('My Title');
        $fixture->setRepo('My Title');
        $fixture->setCategories('My Title');
        $fixture->setTags('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Site');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Site();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setImage('Value');
        $fixture->setRepo('Value');
        $fixture->setCategories('Value');
        $fixture->setTags('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'site[title]' => 'Something New',
            'site[description]' => 'Something New',
            'site[image]' => 'Something New',
            'site[repo]' => 'Something New',
            'site[categories]' => 'Something New',
            'site[tags]' => 'Something New',
        ]);

        self::assertResponseRedirects('/admin/site/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getRepo());
        self::assertSame('Something New', $fixture[0]->getCategories());
        self::assertSame('Something New', $fixture[0]->getTags());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Site();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setImage('Value');
        $fixture->setRepo('Value');
        $fixture->setCategories('Value');
        $fixture->setTags('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/admin/site/');
        self::assertSame(0, $this->repository->count([]));
    }
}
