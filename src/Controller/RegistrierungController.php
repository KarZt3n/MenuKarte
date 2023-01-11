<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrierungController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/reg", name="reg")
     */
    public function reg(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $regForm = $this->createFormBuilder()
            ->add('vorname', TextType::class)
            ->add('nachname', TextType::class)
            ->add('email', TextType::class)
            ->add('passwort', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'required' => true,
                    'first_options' => ['label' => 'Passwort'],
                    'second_options' => ['label' => 'Passwort wiederholen'],
                ]
            )
            ->add('registrieren', SubmitType::class)
            ->getForm()
        ;

        $regForm->handleRequest($request);

        if ($regForm->isSubmitted()){
            $eingabe = $regForm->getData();
            $user = new User();
            $user->setVorname($eingabe['vorname']);
            $user->setNachname($eingabe['nachname']);
            $user->setEmail($eingabe['email']);
            $hashedPassword = $userPasswordHasher->hashPassword(
                $user,
                $eingabe['passwort']
            );
            $user->setPassword($hashedPassword);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('registrierung/index.html.twig', [
            'regForm' => $regForm->createView(),
        ]);
    }
}
