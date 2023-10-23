<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
// use Symfony\Component\Serializer\Annotation\Groups; //ici inutile, mais utile si un jour on rencontre un pb de normalization
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
   // normalizationContext: ['groups' => ['read']], //quand je veux lire l'info, va chercher le groupe read

)]

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
     //   #[Groups(['read'])] //pour chacune des propriétés, on lui dit de ressortir, ici dnas le groupe read
    //ici inutile, mais utile si un jour on rencontre un pb de normalization
    private ?int $id = null;


    #[ORM\Column(length: 255)]
     //   #[Groups(['read'])]     //ici inutile, mais utile si un jour on rencontre un pb de normalization
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'grp', targetEntity: Contact::class)]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setGrp($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getGrp() === $this) {
                $contact->setGrp(null);
            }
        }

        return $this;
    }
}
