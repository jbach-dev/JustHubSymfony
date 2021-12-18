<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use App\Repository\PackageRepository;
use Doctrine\ORM\Mapping\Id;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class PackageController extends AbstractController
{
    #[
        Route('/package', name: 'package_index', methods: ['GET']),
        IsGranted("ROLE_SENDER")
    ]
    public function index(PackageRepository $packageRepository): Response
    {

        return $this->render('package/index.html.twig', [
            'packages' => $packageRepository->findAll(),
        ]);
    }

    #[Route('/package/{id}', name: 'package_show', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function show(Package $package): Response
    {

        return $this->render('package/show.html.twig', [
            'package' => $package,
        ]);
    }

    #[
        Route('/package/create', name: 'package_create', methods: ['GET', 'POST']),
        IsGranted("ROLE_SENDER")
    ]
    public function create(Request $request): Response
    {
        $package = new package();
        $form =  $this->createForm(PackageType::class, $package);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();

            $this->addFlash('green', "Le colis {$package->getId()} a bien été créé.");

            return $this->redirectToRoute('package_index', [
                'id' => $package->getId()
            ]);
        }

        return $this->render('package/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/package/edit/{id}', name: 'package_edit', methods: ['GET', 'POST'])]
    public function edit(Package $package, Request $request): Response
    {
        $form = $this->createForm(PackageType::class, $package);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('green', "Le colis {$package->getId()} a bien été édité.");

            return $this->redirectToRoute('package_index', [
                'id' => $package->getId()
            ]);
        }

        return $this->render('package/edit.html.twig', [
            'form' => $form->createView(),
            'package' => $package
        ]);
    }

    #[Route('/package/delete/{id}/{token}', name: 'package_delete', methods: ['GET'])]
    public function delete(Package $package, $token): Response
    {
        if ($this->isCsrfTokenValid('delete_package', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($package);
            $em->flush();

            $this->addFlash('green', "Le colis {$package->getId()} a bien été supprimé.");

            return $this->redirectToRoute('package_index');
        }

        throw new Exception('Invalid Token !!');
    }

    #[
        Route('/package-hub', name: 'package_indexHub', methods: ['GET']),
        IsGranted("ROLE_HUB")
    ]
    public function indexHub(PackageRepository $packageRepository): Response
    {
        $hubId = $this->getUser()->getHub()->getId();

        // dump($hubId);
        // exit();

        return $this->render('package/indexHub.html.twig', [


            'packages' => $packageRepository->findBy(
                ['hub' => $hubId],
            )
        ]);
    }


    /* Cette route est inutilisée suite à des tests mystiques que 
    nous avons fait, mais messkine ça servira pour un futur projet */

    #[
        Route('/package-sender', name: 'package_indexSender', methods: ['GET']),
        IsGranted("ROLE_SENDER")
    ]
    public function indexSender(PackageRepository $packageRepository): Response
    {
        $show = $this->getUser()->getShow()->getId();

        dump($show);
        exit();

        return $this->render('package/indexSender.html.twig', [


            'packages' => $packageRepository->findBy(
                ['id' => $show],
            )
        ]);
    }
}
