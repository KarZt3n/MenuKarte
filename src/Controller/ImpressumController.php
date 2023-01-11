<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/impressum", name="impressum.")
 */
class ImpressumController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $kontaktForm = $this->createFormBuilder()
            ->add('vorname', TextType::class, [
                'attr' => ['placeholder' => 'Vorname'],
                'required'   => true,
            ])
            ->add('nachname', TextType::class, [
                'attr' => ['placeholder' => 'Nachname'],
                'required'   => true,
            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Deine Email Adresse'],
                'constraints' => [
                    new NotBlank(array("message" => "Please provide a valid email")),
                    new Email(array("message" => "Your email doesn't seems to be valid")),
                ]
            ])
            ->add('betreff', TextType::class, [
                'attr' => ['placeholder' => 'Betreff'],
                'required'   => true,
            ])
            ->add('nachricht', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Deine Nachricht',
                    'rows' => '5',
                ],
                'required'   => true,

            ])
            ->add('senden', SubmitType::class)
            ->getForm()
        ;

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $kontaktForm->handleRequest($request);

            if($kontaktForm->isValid()){
                // Send mail
                if($this->sendEmail($kontaktForm->getData())){

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirect($this->generateUrl('impressum.index'));
                }else{
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render('impressum/index.html.twig', [
            'kontaktForm' => $kontaktForm->createView(),
        ]);
    }

    private function sendEmail($data){
//        $myappContactMail = 'mycontactmail@mymail.com';
//        $myappContactPassword = 'yourmailpassword';
//
//        // In this case we'll use the ZOHO mail services.
//        // If your service is another, then read the following article to know which smpt code to use and which port
//        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
//        $transport = \Swift_SmtpTransport::newInstance('smtp.zoho.com', 465,'ssl')
//            ->setUsername($myappContactMail)
//            ->setPassword($myappContactPassword);
//
//        $mailer = \Swift_Mailer::newInstance($transport);
//
//        $message = \Swift_Message::newInstance("Our Code World Contact Form ". $data["subject"])
//            ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
//            ->setTo(array(
//                $myappContactMail => $myappContactMail
//            ))
//            ->setBody($data["message"]."<br>ContactMail :".$data["email"]);
//
//        return $mailer->send($message);
    }
}
