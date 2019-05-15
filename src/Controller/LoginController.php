<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    public $session;

    /**
     * LoginController constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $repository = $this->getDoctrine()->getRepository(User::class);

            $User = $repository->findOneBy([
                'email' => $form->get('email')->getData(),
                'password' => $form->get('password')->getData(),
            ]);
//            var_dump($User->getId()); exit;
            if ($User){
                $userData['id'] = $User->getId();
                    $userData['name'] = $User->getName();
                $userData['email'] = $User->getEmail();
    //            dump($userData); exit;
                $this->session->set('UserData', $userData);
                return $this->redirectToRoute('dashboard');
            }
            else{
                throw new NotFoundHttpException('No Record Found');
            }

        }

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form'            =>  $form->createView(),
            'button_label'    => 'Login'
        ]);
    }

    /**
     * @Route("/Register", name="Register")
     */
    public function Register(Request $request){
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $user->setGuid(Uuid::uuid4());
            $user->setCreatedby('1');
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('login/Register.html.twig',[
           'form' =>$form->createView(),
            'button_label'    => 'SignUp'
        ]);

    }
}
