<?php

namespace Demontpx\EasyTwig\Tests;

use Demontpx\EasyTwig\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;
use Twig_Error_Loader;

/**
 * Class ControllerTest
 *
 * @author    Wessel Strengholt <wessel.strengholt@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Controller */
    private $controller;

    /** @var \PHPUnit_Framework_MockObject_MockObject|Twig_Environment */
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
     * @param string $path
     * @param string $expectedPath
     *
     * @dataProvider pathDataProvider
     */
    public function testPage($path, $expectedPath)
    {
        $this->request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue($path));

        $pageContent = 'This is the page content';

        $expectedContext = array(
            'request' => $this->request,
        );

        $this->twig->expects($this->once())
            ->method('render')
            ->with('page/' . $expectedPath, $expectedContext)
            ->will($this->returnValue($pageContent));

        $result = $this->controller->page($this->request);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $result);
        $this->assertSame($pageContent, $result->getContent());
    }

    /**
     * @return array
     */
    public function pathDataProvider()
    {
        return array(
            array('/', 'index.html.twig'),
            array('/contact', 'contact.html.twig'),
            array('/contact/', 'contact/index.html.twig'),
            array('/contact/about-us', 'contact/about-us.html.twig'),
        );
    }

    public function testPageException()
    {
        $this->request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue('/fail'));

        $this->twig->expects($this->at(0))
            ->method('render')
            ->with('page/fail.html.twig')
            ->will($this->throwException(new Twig_Error_Loader('Unable to find template')));

        $this->twig->expects($this->at(1))
            ->method('render')
            ->with('error/404.html.twig');

        $result = $this->controller->page($this->request);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $result);
        $this->assertSame(404, $result->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Twig_Environment
     */
    private function createMockTwig()
    {
        return $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Request
     */
    private function createMockRequest()
    {
        return $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableArgumentCloning()
            ->getMock();
    }
}
