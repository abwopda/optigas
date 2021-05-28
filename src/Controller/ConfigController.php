<?php

namespace App\Controller;

use App\Entity\Config;
use App\Entity\Image;
use App\Gateway\ConfigGateway;
use App\Gateway\ImageGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * config controller.
 *
 */
class ConfigController extends AbstractController
{
    private ImageGateway $imageGateway;
    private ConfigGateway $configGateway;

    /**
     * ConfigController constructor.
     * @param ImageGateway $imageGateway
     * @param ConfigGateway $configGateway
     */
    public function __construct(
        ImageGateway $imageGateway,
        ConfigGateway $configGateway
    ) {
        $this->imageGateway = $imageGateway;
        $this->configGateway = $configGateway;
    }


    public function index()
    {
        $img = new image();
        $imgform   = $this->createForm($this->imageGateway->getTypeClass(), $img);

        return $this->render('ui/Config/index.html.twig', array(
            'imgform' => $imgform->createView()
        ));
    }

    public function show(int $id)
    {
        $entity = $this->configGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le parametre d'id  " . $id);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ui/Config/show.html.twig', [
            "entity"      => $entity,
            "delete_form" => $deleteForm->createView(),
        ]);
    }

    public function new()
    {
        $entity = new Config();
        $form   = $this->createForm($this->configGateway->getTypeClass(), $entity);

        return $this->render('ui/Config/new.html.twig', array(
            "entity" => $entity,
            "form"   => $form->createView(),
        ));
    }

    public function create(Request $request): Response
    {
        $entity  = new config();
        $form = $this->createForm($this->configGateway->getTypeClass(), $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->configGateway->create($entity);

            $this->addFlash('success', "Parametre créé avec succès");
            return $this->redirectToRoute("config.show", ["id" => ($entity->getId() ? $entity->getId() : 1)]);
        }

        return $this->render('ui/Config/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function edit(int $id)
    {
        $entity = $this->configGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException("Impossible de trouver le parametre d'id  " . $id);
        }
        $editForm = $this->createForm($this->configGateway->getTypeClass(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ui/Config/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateone(int $id, Request $request)
    {
        $entity = $this->configGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le parametre d"id' . $id);
        }

        $deleteForm = $this->createDeleteForm($id);
        $editform = $this->createForm($this->configGateway->getTypeClass(), $entity)->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $this->configGateway->update($entity);

            $this->addFlash('success', "Parametre mis à jour avec succès");
            return $this->redirectToRoute("config.show", ["id" => $id]);
        }

        $this->addFlash('danger', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render("ui/Config/edit.html.twig", [

            "entity" => $entity,
            "edit_form" => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function update(Request $request)
    {
        $config = $request->get('config');

        /* handle img */
        $img = new image();
        $imgform   = $this->createForm($this->imageGateway->getTypeClass(), $img);

        $imgform->handleRequest($request);

        if ($img->upload()) {
            $config['app_logo'] = $img->getWebPath();
        }

        //die(json_encode($config));

        foreach ($config as $key => $value) {
            $this->configGateway->updateBy($key, $value);
        }

        $this->get('session')->getFlashBag()->add('success', "Vos modifications ont été enregistré avec succée.");
        return $this->redirect($this->generateUrl('config'));
    }

    public function delete(Request $request, int $id)
    {
        $entity = $this->configGateway->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le parametre d"id' . $id);
        }
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $this->configGateway->delete($entity);

            $this->get('session')->getFlashBag()->add('success', "Action effectué avec succée.");
        }

        return $this->redirect($this->generateUrl('config'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
        ;
    }
}
