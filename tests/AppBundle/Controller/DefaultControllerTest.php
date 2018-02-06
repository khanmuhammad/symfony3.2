<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Submit application', $crawler->filter('#form-heading')->text());
    }

    public function testAdminLogin(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $username = 'lengoo';
        $password = 'lengoo';
        $crawler = $client->submit($form,array('_username' => $username,'_password' => $password));
        $this
            ->assertRegExp('/\/admin/',
                $client->getResponse()->getContent());
    }

    public function testApplicationSubmission(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Submit')->form();
        $file = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(10, 10), $file); // create and write image/png to it
        $image = new UploadedFile(
        # Path to the file to send
            $file,
            # Name of the sent file
            'apple-touch-icon.png',
            # MIME type
            'image/png',
            # Size of the file
            9988
        );
        $values = array(
            'application' => array(
                'name' => 'Test Name',
                '_token' => $form['application[_token]']->getValue(),
                'email' => 'test@test.com',
                'address' => 'testing Address Needs to be here',

            ),
        );
        $files = array(
            'application' => array('file_name' =>  $image)
        );
        $client->followRedirects(true);
        $crawler = $client->request(
            $form->getMethod(),
            $form->getUri(),
            $values,
            $files
        );
        $this->assertContains('Your Application is submitted we will response ASAP', $crawler->filter('.alert')->text());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

}



