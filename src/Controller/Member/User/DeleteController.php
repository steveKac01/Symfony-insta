<?php

namespace App\Controller\Member\User;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteContoller extends AbstractController
{
    #[Security('is_granted("ROLE_USER") and user === userSelected')]
    #[route('delete/user/{id}/','user.delete',methods:['GET','POST'])]
    function delete(Request $request,User $userSelected):Response
    {
        $form = $this->createForm(DeleteAccountType::class,$userSelected);

        return $this->render('user/delete.html.twig',["form" => $form]);
    }

}