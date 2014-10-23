<?php

namespace Demontpx\EasyTwig\Tests;

use Demontpx\EasyTwig\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    /** @var \PHPUnit_Framework_MockObject_MockObject|Twig_Environment */
    private $twig;

    /** @var \PHPUnit_Framework_MockObject_MockObject|Request */
    private $request;

    public function setUp()
    {
        $this->twig = $this->createMockTwig();
        $this->request = $this->createRequestMock();
    }

    /**
     * @param string $path
     * @param string $expectedPath
     *
     * @dataProvider pathDataProvider
     */
    public function testPage($path, $expectedPath)
    {
        $controller = new Controller($this->twig);

        $this->request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue($path));

        $this->twig->expects($this->once())
            ->method('render')
            ->with('page' . DIRECTORY_SEPARATOR . $expectedPath . '.html.twig');

        $this->assertInstanceOf(Response::class, $controller->page($this->request));
    }

    /**
     * @return array
     */
    public function pathDataProvider()
    {
        return array(
            array('contact', 'contact'),
            array('contact/', 'contact/index'),
        );
    }

    public function testPageException()
    {
        $controller = new Controller($this->twig);

        $this->request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue('fail'));

        $this->twig->expects($this->at(0))
            ->method('render')
            ->with('page' . DIRECTORY_SEPARATOR . 'fail' . '.html.twig')
            ->will($this->throwException(new Twig_Error_Loader('could not twig')));

        $this->twig->expects($this->at(1))
            ->method('render')
            ->with('error' . DIRECTORY_SEPARATOR . '404.html.twig');

        $errorResponse = $controller->page($this->request);

        $this->assertInstanceOf(Response::class, $errorResponse);
        $this->assertSame(404, $errorResponse->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Twig_Environment
     */
    private function createMockTwig()
    {
        return $this->getMockBuilder(Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Request
     */
    private function createRequestMock()
    {
        return $this->getMockBuilder(Request::class)
            ->disableArgumentCloning()
            ->getMock();
    }
}