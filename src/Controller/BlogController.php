<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/blog")
*/
class BlogController extends AbstractController
{
    protected $session;

    /**
     * BlogController constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session){
        $this->session = $session;
    }
    /**
     * @Route("/",name = "blog_index")
    */

    public function index()
    {
        $posts = $this->session->get('post');
        return $this->render("blog/index.html.twig",[
           'post' => $posts
        ]);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add(){
        $posts = $this->session->get('post');
        $posts[uniqid()] = [
            'title' => 'Random Title'. rand(1,50),
            'text' => 'Random text'. rand(1,50)
        ];
        $this->session->set('post',$posts);
        return new RedirectResponse('/');
    }


    public function show($id){
        $post = $this->session->get('post');
//        if(!$post )
    }


}
?>