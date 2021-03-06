<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Dojo
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */


/**
 * Test class for Zend_Dojo
 *
 * @category   Zend
 * @package    Zend_Date
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Dojo
 */
class Zend_Dojo_DojoTest extends PHPUnit\Framework\TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
    }

    public function getForm()
    {
        $form = new Zend_Form();
        $form->addElement('text', 'foo')
             ->addElement('text', 'bar')
             ->addElement('text', 'baz')
             ->addElement('text', 'bat');
        $subForm = new Zend_Form_SubForm();
        $subForm->addElement('text', 'foo')
                ->addElement('text', 'bar')
                ->addElement('text', 'baz')
                ->addElement('text', 'bat');
        $form->addDisplayGroup(array('foo', 'bar'), 'foobar')
             ->addSubForm($subForm, 'sub')
             ->setView(new Zend_View);
        return $form;
    }

    public function testEnableFormShouldSetAppropriateDecoratorAndElementPaths()
    {
        $form = $this->getForm();
        Zend_Dojo::enableForm($form);

        $decPluginLoader = $form->getPluginLoader('decorator');
        $paths           = $decPluginLoader->getPaths('Zend_Dojo_Form_Decorator');
        $this->assertInternalType('array', $paths);

        $elPluginLoader = $form->getPluginLoader('element');
        $paths          = $elPluginLoader->getPaths('Zend_Dojo_Form_Element');
        $this->assertInternalType('array', $paths);

        $decPluginLoader = $form->baz->getPluginLoader('decorator');
        $paths           = $decPluginLoader->getPaths('Zend_Dojo_Form_Decorator');
        $this->assertInternalType('array', $paths);

        $decPluginLoader = $form->foobar->getPluginLoader();
        $paths           = $decPluginLoader->getPaths('Zend_Dojo_Form_Decorator');
        $this->assertInternalType('array', $paths);

        $decPluginLoader = $form->sub->getPluginLoader('decorator');
        $paths           = $decPluginLoader->getPaths('Zend_Dojo_Form_Decorator');
        $this->assertInternalType('array', $paths);

        $elPluginLoader = $form->sub->getPluginLoader('element');
        $paths          = $elPluginLoader->getPaths('Zend_Dojo_Form_Element');
        $this->assertInternalType('array', $paths);
    }

    public function testEnableFormShouldSetAppropriateDefaultDisplayGroup()
    {
        $form = $this->getForm();
        Zend_Dojo::enableForm($form);
        $this->assertEquals('Zend_Dojo_Form_DisplayGroup', $form->getDefaultDisplayGroupClass());
    }

    public function testEnableFormShouldSetAppropriateViewHelperPaths()
    {
        $form = $this->getForm();
        Zend_Dojo::enableForm($form);
        $view         = $form->getView();
        $helperLoader = $view->getPluginLoader('helper');
        $paths        = $helperLoader->getPaths('Zend_Dojo_View_Helper');
        $this->assertInternalType('array', $paths);
    }

    public function testEnableViewShouldSetAppropriateViewHelperPaths()
    {
        $view = new Zend_View;
        Zend_Dojo::enableView($view);
        $helperLoader = $view->getPluginLoader('helper');
        $paths        = $helperLoader->getPaths('Zend_Dojo_View_Helper');
        $this->assertInternalType('array', $paths);
    }
}
