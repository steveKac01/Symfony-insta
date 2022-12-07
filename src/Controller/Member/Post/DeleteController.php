<?php

namespace App\Controller\Member\Post;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * This route delete a post if found. If not redirect to the home with a flash error.
     */
    #[Security("is_granted('ROLE_USER') and user === image.getUserImage()")]
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

        $manager->remove($image);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre post a bien été effacé !'
        );
        
        return $this->redirectToRoute('home');
    }
}
