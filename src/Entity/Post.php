<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\Comment;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Your title must be at least {{ limit }} characters long',
        maxMessage: 'Your title cannot be longer than {{ limit }} characters',
    )]
    private ?string $title = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'The description can\'t be empty.')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Your description must be at least {{ limit }} characters long',
        maxMessage: 'Your description cannot be longer than {{ limit }} characters',
    )]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $upload_at = null;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $url = null;
    
    #[Assert\File(maxSize: 1048576, maxSizeMessage: "The file is too big must be lesser than 1 mo.")]
    #[Vich\UploadableField(mapping: 'postThumbnail', fileNameProperty: 'url')]
    private ?File $postThumbnail = null;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToOne]
    private ?Category $category = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete:'cascade')]
    private ?User $userPost = null;
 

    public function __construct()
    {
        $this->upload_at = new DateTimeImmutable();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUploadAt(): ?\DateTimeImmutable
    {
        return $this->upload_at;
    }

    public function setUploadAt(\DateTimeImmutable $upload_at): self
    {
        $this->upload_at = $upload_at;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            #$comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            // if ($comment->getPost() === $this) {
            //     $comment->setPost(null);
            // }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUserPost(): ?User
    {
        return $this->userPost;
    }

    public function setUserPost(?User $userPost): self
    {
        $this->userPost = $userPost;

        return $this;
    }

    /**
     * Get the value of postThumbnail
     *
     * @return ?File
     */
    public function getPostThumbnail(): ?File
    {
        return $this->postThumbnail;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $postThumbnail
     */
    public function setPostThumbnail(?File $postThumbnail = null): void
    {
        $this->postThumbnail = $postThumbnail;

        if (null !== $postThumbnail) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->upload_at = new \DateTimeImmutable();
        }
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
