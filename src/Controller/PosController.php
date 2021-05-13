<?php

namespace App\Controller;

use App\Entity\Pos;
use App\Form\PosType;
use App\Gateway\PosGateway;
use App\UseCase\CreatePos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class PosController
 * @package App\Controller
 */
class PosController extends AbstractController
{
    private CreatePos $createPos;
    private PosGateway $posGateway;
    private Security $security;

    /**
     * PosController constructor.
     * @param CreatePos $createPos
     * @param PosGateway $posGateway
     * @param Security $security
     */
    public function __construct(
        CreatePos $createPos,
        PosGateway $posGateway,
        Security $security
    ) {
        $this->createPos = $createPos;
        $this->posGateway = $posGateway;
        $this->security = $security;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $entity = new Pos();

        $user =  $this->security->getUser();

        $entity->setCreateBy($user);

        $form = $this->createForm(PosType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPos->execute($entity);
            //var_export($entity);
            $this->addFlash('success', "Point de vente créé avec succès");
            return $this->redirectToRoute("pos.show", ["pos" => 1]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/pos/create.html.twig", [
            "entity" => $entity,
            "form" => $form->createView()
        ]);
    }

    public function show(int $pos)
    {
        if (!$pos) {
            throw $this->createNotFoundException('Impossible de trouver le point de vente d"id' . $pos);
        }

        $entity = $this->posGateway->findOneById($pos);

        return $this->render('ui/pos/show.html.twig', [
            'entity'      => $entity,
        ]);
    }
}
