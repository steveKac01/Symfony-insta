<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * This route delete a post if found. If not redirect to the home with a flash error.
     */
    #[route('member/image/delete/{id}', 'image.delete', methods: ['GET'])]
    public function delete(Image $image, EntityManagerInterface $manager): Response
    {
        if (!$image) {
            $this->addFlash(
                'error',
                'Ce post est introuvable !'
            );

            return $this->redirectToRoute('home');
        }

        if($this->getUser()!== $image->getUserImage()){
            $this->addFlash(
                'error', 'Impossible de supprimer ce post.');
            return $this->redirectToRoute('home');
        }

        $manager->remove($image);
        $manager->flush();

        $this->addFlash(
            'success',
            'Ce post a bien été effacé !'
        );
        
        return $this->redirectToRoute('home');
    }
}
