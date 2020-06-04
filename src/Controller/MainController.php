<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     * @Route("/mail", name="mail", methods={"POST"})
     */
    public function mail(Request $request, MailerInterface $mailer)
    {
        $submittedToken = $request->request->get('csrfmiddlewaretoken');

        
        if ($this->isCsrfTokenValid('email', $submittedToken)) {
        
        $email = (new Email())
        ->from($_POST['email'])
        ->to('anstettdevweb@gmail.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Contact Anstett dev web')
        ->text('Sending emails is fun again!')
        ->html('<p>'.'Email:'.' '.$_POST['email'].' '.'</p>'.'<br>'.'<p>'.'Nom:'.' '.$_POST['name'].'</p>'.'<br>'.'<p>'.'Numero de téléphone:'.' '.$_POST['phone'].'</p>'.'<br>'.'<p>'.'Message:'.' '.$_POST['message'].' '.'</p>');

        $mailer->send($email);

        return new JsonResponse('ok', 200);
        }

        return new JsonResponse('token invalid', 300);
    }



    /**
     * @Route("/pdf", name="pdf" )
     */
    public function downloadAction()
    {
        $pdfPath = $this->getParameter('dir.downloads').'/CVAnstettVictor.pdf';

        return $this->file($pdfPath);
    }


}
