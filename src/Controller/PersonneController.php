<?php

namespace App\Controller;
use App\Repository\PersonneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Personne;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PersonneType;
use Symfony\Component\Form\FormView;
use App\Form\CallCenterGroupsType;
use Monolog\DateTimeImmutable;
use DateTime;
use App\Entity\DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RecherchesType;
//use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class PersonneController extends AbstractController
{
    /**
     * this function display all persons
     *
     * @param PersonneRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/personne', name: 'app_personne',methods:['GET'])]
    public function index(PersonneRepository $repository, PaginatorInterface $paginator, Request $request ): Response
    {
        $personnes = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('pages/personne/index.html.twig',['personnes' => $personnes]);
    }


    /**
     * This controller show a form which add person
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/personne/nouveau', name: 'personne.new',methods:['GET','POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ) : Response {

        $personne = new Personne();
        $form = $this->createForm(PersonneType::class,$personne);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            //$personne->setUser($this->getUser());

            $manager->persist($personne);
            $manager->flush();

            $this->addFlash(
                'success',
                'Personne ajoutée avec succès !'
            );

            return $this->redirectToRoute('app_personne');
        }

        return $this->render('pages/personne/new.html.twig',
                ['form'=>$form->createView()]);
    }



    #[Route('/personne/edition/{id}', 'personne.edit', methods: ['GET', 'POST'])]
    public function edit(
        Personne $personne,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();

            $manager->persist($personne);
            $manager->flush();

            $this->addFlash(
                'success',
                'La personne a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_personne');
        }

        return $this->render('pages/personne/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/personne/suppression/{id}', 'personne.delete', methods: ['GET'])]

    public function delete(
        EntityManagerInterface $manager,
        Personne $personne
    ): Response {
        $manager->remove($personne);
        $manager->flush();

        $this->addFlash(
            'success',
            'La personne a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_personne');
    }

    
    #[Route('/personne/recherche', name: 'recherche')]
    //#[Route('/personnes/rechercher', name: 'recherchePage')]
    public function recherchePage(Request $request, PersonneRepository $repo): Response
    {
        $nomRechercher = $request->request->get('nomRechercher');
        $listePersonnes = [];

        if (!empty($nomRechercher)) {
            $listePersonnes = $repo->createQueryBuilder('p')
                ->where('p.nom like :nom')
                ->setParameter('nom', '%' . $nomRechercher . '%')
                ->getQuery()
                ->getResult();
        }

        $message = '';
        if (count($listePersonnes) == 0 && !empty($nomRechercher)) {
            $message = 'Aucun résultat trouvé pour "' . $nomRechercher . '"';
        }

        return $this->render('pages/personne/recherche.html.twig', [
            'listePersonnes' => $listePersonnes,
            'message' => $message
        ]);
    }



    /*
    public function recherche(Request $request): Response
    {
        $personnes = [];

        $form = $this->createForm(RecherchesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();

            $personnes = $this->getDoctrine()
            ->getRepository(Personne::class)
            ->createQueryBuilder('p')
            ->where('p.nom LIKE :nom')
            ->setParameter('nom', $nom.'%')
            ->getQuery()
            ->getResult();

            return $this->redirectToRoute('pages/personne/recherche.html.twig');
    }

    return $this->render('pages/personne/recherche.html.twig', [
        'form' => $form->createView(),
        'personnes' => $personnes,
    ]);
}
*/

}
