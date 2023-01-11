<?php

namespace App\Test\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private NewsRepository $repository;
    private string $path = '/news/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(News::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('News index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'news[name]' => 'Testing',
            'news[slug]' => 'Testing',
            'news[teaser]' => 'Testing',
            'news[bodytext]' => 'Testing',
            'news[createAt]' => 'Testing',
            'news[modifyAt]' => 'Testing',
            'news[hide]' => 'Testing',
            'news[deleted]' => 'Testing',
            'news[isEvent]' => 'Testing',
            'news[dailyEvent]' => 'Testing',
            'news[eventStart]' => 'Testing',
            'news[eventEnde]' => 'Testing',
            'news[bild]' => 'Testing',
            'news[bilder]' => 'Testing',
        ]);

        self::assertResponseRedirects('/news/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new News();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setTeaser('My Title');
        $fixture->setBodytext('My Title');
        $fixture->setCreateAt('My Title');
        $fixture->setModifyAt('My Title');
        $fixture->setHide('My Title');
        $fixture->setDeleted('My Title');
        $fixture->setIsEvent('My Title');
        $fixture->setDailyEvent('My Title');
        $fixture->setEventStart('My Title');
        $fixture->setEventEnde('My Title');
        $fixture->setBild('My Title');
        $fixture->setBilder('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('News');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new News();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setTeaser('My Title');
        $fixture->setBodytext('My Title');
        $fixture->setCreateAt('My Title');
        $fixture->setModifyAt('My Title');
        $fixture->setHide('My Title');
        $fixture->setDeleted('My Title');
        $fixture->setIsEvent('My Title');
        $fixture->setDailyEvent('My Title');
        $fixture->setEventStart('My Title');
        $fixture->setEventEnde('My Title');
        $fixture->setBild('My Title');
        $fixture->setBilder('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'news[name]' => 'Something New',
            'news[slug]' => 'Something New',
            'news[teaser]' => 'Something New',
            'news[bodytext]' => 'Something New',
            'news[createAt]' => 'Something New',
            'news[modifyAt]' => 'Something New',
            'news[hide]' => 'Something New',
            'news[deleted]' => 'Something New',
            'news[isEvent]' => 'Something New',
            'news[dailyEvent]' => 'Something New',
            'news[eventStart]' => 'Something New',
            'news[eventEnde]' => 'Something New',
            'news[bild]' => 'Something New',
            'news[bilder]' => 'Something New',
        ]);

        self::assertResponseRedirects('/news/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getTeaser());
        self::assertSame('Something New', $fixture[0]->getBodytext());
        self::assertSame('Something New', $fixture[0]->getCreateAt());
        self::assertSame('Something New', $fixture[0]->getModifyAt());
        self::assertSame('Something New', $fixture[0]->getHide());
        self::assertSame('Something New', $fixture[0]->getDeleted());
        self::assertSame('Something New', $fixture[0]->getIsEvent());
        self::assertSame('Something New', $fixture[0]->getDailyEvent());
        self::assertSame('Something New', $fixture[0]->getEventStart());
        self::assertSame('Something New', $fixture[0]->getEventEnde());
        self::assertSame('Something New', $fixture[0]->getBild());
        self::assertSame('Something New', $fixture[0]->getBilder());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new News();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setTeaser('My Title');
        $fixture->setBodytext('My Title');
        $fixture->setCreateAt('My Title');
        $fixture->setModifyAt('My Title');
        $fixture->setHide('My Title');
        $fixture->setDeleted('My Title');
        $fixture->setIsEvent('My Title');
        $fixture->setDailyEvent('My Title');
        $fixture->setEventStart('My Title');
        $fixture->setEventEnde('My Title');
        $fixture->setBild('My Title');
        $fixture->setBilder('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/news/');
    }
}
