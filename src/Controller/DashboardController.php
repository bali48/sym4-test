<?php

namespace App\Controller;

use App\Entity\Department;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\TicketType;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;

class DashboardController extends AbstractController
{
    public $session;
    public $entityManager;
    public $request;

    /**
     * DashboardController constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

//        $this->entityManager = $em;
    }


    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {
        $userData = $this->session->get('UserData');
//        dump($userData); exit;
        if(!isset($userData)){
            throw $this->createNotFoundException('Sorry Session Expire');
        }else{
            $this->entityManager = $this->getDoctrine()->getManager();
            $ticket = new Ticket();
            $form = $this->createForm(TicketType::class,$ticket,[
                'action' => $this->generateUrl('dashboard')
            ]);
            //is this one is first Ticket.
            if ($request->isXmlHttpRequest()) {
//                dump($request->request->get('Title')); exit;
                $title = $request->request->get('Title');
                $Description = $request->request->get('Description');
                $department = $request->request->get('Department');
                $user = $this->getDoctrine()->getRepository(User::class)->find($userData['id']);
                $status = $this->getDoctrine()->getRepository(Status::class)->find(1);
//                dump($user); exit;
                $ticket->setTitle($title);
                $ticket->setDescription($Description);
                $ticket->setUserid($user);
                $ticket->setDepartment($department);
                $ticket->setStatusid($status);

                try{
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($ticket);
                    $em->flush();
                    $this->addFlash('success','Ticket has been Generated Successfully');
                    return new JsonResponse(['data'=>'ok']);
                }catch (\Exception $ex){
                    $this->addFlash('error',$ex->getMessage());
                    return new JsonResponse(['data'=>$ex->getMessage()]);
                }



            }
            $user = $this->entityManager->getRepository(User::class)->find($userData['id']);

            $tickets = $this->entityManager->getRepository(Ticket::class)->findAllTicketsByUserID($user);
//            ->findBy(['userid' => $user]);//dump($tickets); exit;
            return $this->render('dashboard/index.html.twig', [
                'tickets' => $tickets,
                'form'    => $form->createView()
            ]);
        }

    }

    /**
     * @Route("/update_ticket/{id}", name="update_ticket")
     *
     */
    public function Update_Ticket(Ticket $ticket,Request $request){
            $form = $this->createForm(TicketType::class, $ticket);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('dashboard');
            }
            return $this->render('dashboard/editticket.html.twig',[
                'ticket' => $ticket,
                'form'   => $form->CreateView()
            ]);

    }

    /**
     * @Route("/delete_ticket/{id}", name="delete_ticket")
     *
     */
    public function DeleteTicket(Ticket $ticket, Request $request){
        $form = $this->createForm(TicketType::class, $ticket);
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $this->getDoctrine()->getManager()->remove($ticket);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('dashboard');
    }

}
