<?php

namespace Tests\Demontpx\EasyTwig;

use Demontpx\EasyTwig\Controller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;

/**
 * @copyright 2014 Bert Hekman
 */
class ControllerTest extends TestCase
{
    /** @var Controller */
    private $controller;
    /** @var \PHPUnit_Framework_MockObject_MockObject|Environment */
    private $twig;
    /** @var \PHPUnit_Framework_MockObject_MockObject|Request */
    private $request;

    public function setUp()
    {
        $this->request = $this->createMockRequest();
        $this->twig = $this->createMockTwig();
        $this->controller = new Controller($this->twig);
    }

    /**
     * @dataProvider pathDataProvider
     */
    public function testPage(string $path, string $expectedPath)
    {
        $this->request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue($path));

        $pageContent = 'This is the page content';

        $expectedContext = [
            'request' => $this->request,
        ];

        $this->twig->expects($this->once())
            ->method('render')
            ->with('page/' . $expectedPath, $expectedContext)
            ->will($this->returnValue($pageContent));

        $result = $this->controller->page($this->request);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame($pageContent, $result->getContent());
    }

    public function pathDataProvider()
    {
        return [
            ['/', 'index.html.twig'],
            ['/contact', 'contact.html.twig'],
            ['/contact/', 'contact/index.html.twig'],
            ['/contact/about-us', 'contact/about-us.html.twig'],
        ];
    }

    public function testPageException()
    {
        $this->request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue('/fail'));

        $this->twig->expects($this->at(0))
            ->method('render')
            ->with('page/fail.html.twig')
            ->will($this->throwException(new LoaderError('Unable to find template')));

        $this->twig->expects($this->at(1))
            ->method('render')
            ->with('error/404.html.twig');

        $result = $this->controller->page($this->request);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $result);
        $this->assertSame(404, $result->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Environment
     */
    private function createMockTwig()
    {
        return $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Request
     */
    private function createMockRequest()
    {
        return $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
