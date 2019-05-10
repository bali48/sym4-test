<?php
namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    public $session;
    /**
     * LuckyController constructor.
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/lucky", name="lucky")
     * @param Request $request
     * @return Response
     */
 
    public function number(Request $request)
    {

            $form = $this->createForm(ContactType::class);
            $form->handleRequest($request);

           if ($form->isSubmitted()) {
               $new_message = $this->session->get('messages');
               $data = $form->getData();
               $new_message[] = [
                   'title' => $data['Title'],
                   'detail' => $data['Detail']
               ];
               $this->session->set('messages',$new_message);
               $this->addFlash('success', 'Form submitted successfully');
               return $this->redirectToRoute('lucky');
           }
            $messages = $this->session->get('messages');
            return $this->render('lucky/number.html.twig',[
                'messages' => $messages,
                'our_form' => $form->createView(),
            ]);

    }

}