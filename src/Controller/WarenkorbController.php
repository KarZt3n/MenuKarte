<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Entity\User;
use App\Entity\Warenkorb;
use App\Repository\GerichtRepository;
use App\Repository\WarenkorbRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use function PHPUnit\Framework\isNull;

/**
 * @Route("/warenkorb", name="warenkorb.")
 */
class WarenkorbController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    private $doctrine;
    private $email;
    private $isEmail = false;

    public function __construct(Security $security, ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
        $this->security = $security;

        $this->email = $this->security->getUser()? $this->security->getUser()->getUserIdentifier() : null;
        if (!is_null($this->email)){
            $this->isEmail = true;
        }
    }

    /**
     * @Route("/", name="index")
     */
    public function index(WarenkorbRepository $warenkorbRepository, GerichtRepository $gerichtRepository): Response
    {
        $warenkorb = $warenkorbRepository->findAllByEmail($this->email);

        foreach ($warenkorb as $key => $value){
            $gericht  = $gerichtRepository->find($value['artikel_id']);
            $warenkorb[$key]['artikelDetails'] = $gericht;
        }

        return $this->render('warenkorb/index.html.twig', [
            'warenkorb' => $warenkorb,
            'email' => $this->email,
            'isEmail' => $this->isEmail,
        ]);
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(WarenkorbRepository $warenkorbRepository, Gericht $gericht){
        if ($this->isEmail){
            $em = $this->doctrine->getManager();

            $user = $this->security->getUser();
            $email = $user->getUserIdentifier();

            //wenn bereits der Artikel im Warenkorb vorhnaden ist, setze Menge um 1 hoch
            $product = $em->getRepository(Warenkorb::class)->findOneBy(array('artikelID' => $gericht->getId(), 'email' => $this->email));
            if ($product){
                //erhöhe die Anzahl um 1
                $product->setAnzahl($product->getAnzahl()+1);
                $this->addFlash('warenkorb', $product->getArtikelname() . ' wurde eine weitere Anzahl im Warenkorb hinzugefügt!');
                return $this->update($product, 'menu');
            }

            $warenkorb = new Warenkorb();
            $warenkorb->setArtikelID($gericht->getId());
            $warenkorb->setArtikelname($gericht->getName());
            $warenkorb->setAnzahl(1);
            $warenkorb->setEpreis($gericht->getPreis());
            $warenkorb->setEmail($email);

            //entityManager
            $em = $this->doctrine->getManager();
            $em->persist($warenkorb);
            $em->flush();

            $this->addFlash('warenkorb', $gericht->getName(). ' wurde zum Warenkorb hinzugefügt!');

            return $this->redirect($this->generateUrl('menu'));
        }else {
            return $this->redirect($this->generateUrl('app_login'));
        }
    }

    /**
     * @Route("/increase/{id}", name="increase")
     */
    public function increase(Gericht $gericht){
        if ($this->isEmail) {
            $em = $this->doctrine->getManager();

            $user = $this->security->getUser();
            $email = $user->getUserIdentifier();

            //wenn bereits der Artikel im Warenkorb vorhnaden ist, setze Menge um 1 hoch
            $product = $em->getRepository(Warenkorb::class)->findOneBy(array('artikelID' => $gericht->getId(), 'email' => $this->email));
            if ($product) {
                //erhöhe die Anzahl um 1
                $product->setAnzahl($product->getAnzahl() + 1);
//                $this->addFlash('warenkorb', $product->getArtikelname() . ' wurde eine weitere Anzahl im Warenkorb hinzugefügt!');
                return $this->update($product, 'warenkorb.index');
            }
        }
    }

    /**
     * @Route("/decrease/{id}", name="decrease")
     */
    public function decrease(Gericht $gericht){
        if ($this->isEmail) {
            $em = $this->doctrine->getManager();

            $user = $this->security->getUser();
            $email = $user->getUserIdentifier();

            //wenn bereits der Artikel im Warenkorb vorhnaden ist, setze Menge um 1 hoch
            $product = $em->getRepository(Warenkorb::class)->findOneBy(array('artikelID' => $gericht->getId(), 'email' => $this->email));
            if ($product) {
                if ($product->getAnzahl() <= 1){
                    return $this->delete($product);
                }
                if ($product->getAnzahl() >= 2){
                    $product->setAnzahl($product->getAnzahl() - 1);
                    return $this->update($product, 'warenkorb.index');
                }
            }
            return $this->redirect($this->generateUrl('menu'));
        }
        return $this->redirect($this->generateUrl('app_login'));
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(WarenkorbRepository $warenkorbRepository, Gericht $gericht){
        if ($this->isEmail){
            $em = $this->doctrine->getManager();

            $user = $this->security->getUser();
            $email = $user->getUserIdentifier();

            //wenn bereits der Artikel im Warenkorb vorhnaden ist, setze Menge um 1 hoch
            $product = $em->getRepository(Warenkorb::class)->findOneBy(array('artikelID' => $gericht->getId(), 'email' => $this->email));
            if ($product){
                $this->addFlash('warenkorb', $product->getArtikelname() . ' wurde aus deinem Warenkorb entfernt!');
                return $this->delete($product);
            }
        }
        return $this->redirect($this->generateUrl('warenkorb.index'));;
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($product){
        //entityManager
        $em = $this->doctrine->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirect($this->generateUrl('warenkorb.index'));
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($product, $redirectTo){
        //entityManager
        $em = $this->doctrine->getManager();
        $em->persist($product);
        $em->flush();
        return $this->redirect($this->generateUrl($redirectTo));
    }
}
