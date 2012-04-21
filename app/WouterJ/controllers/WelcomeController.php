<?php

namespace snakeMvc\Bundle\WouterJ\Controllers;

use snakeMvc\Framework\BrowserKit\Response;
use snakeMvc\Framework\Controller\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        $template = $this->getTemplate();
        return new Response($template->join('index.html.twig', 'site_name=WouterJ'));
    }

    public function sayHelloForm()
    {
        return new Response('<form action=/snakeMvc/index.php/hello/ method=post><label>Naam: <input type=text name=naam></label><br><label>Text: <input type=text name=txt></label><br><input type=submit value=verzenden></form>');
    }

    public function sayHello()
    {
        $request = $this->getRequest();
        return new Response($request->post['txt'].' '.$request->post['naam']);
    }
}
