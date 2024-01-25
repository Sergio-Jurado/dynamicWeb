<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: MenuRepository::class)]

class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etiqueta = null;

    #[ORM\Column(length: 500)]
    private ?string $destino = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'menus')]
    private ?self $subMenu = null;

    #[ORM\OneToMany(mappedBy: 'subMenu', targetEntity: self::class)]
    private Collection $menus;

    #[ORM\OneToOne(mappedBy: 'menu', cascade: ['persist', 'remove'])]
    private ?Pagina $pagina = null;

    #[ORM\Column]
    private ?int $menuOrder = null;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtiqueta(): ?string
    {
        return $this->etiqueta;
    }

    public function setEtiqueta(string $etiqueta): static
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    public function getDestino(): ?string
    {
        return $this->destino;
    }

    public function setDestino(string $destino): static
    {
        $this->destino = $destino;

        return $this;
    }

    public function getSubMenu(): ?self
    {
        return $this->subMenu;
    }

    public function setSubMenu(?self $subMenu): static
    {
        $this->subMenu = $subMenu;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(self $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setSubMenu($this);
        }

        return $this;
    }

    public function removeMenu(self $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getSubMenu() === $this) {
                $menu->setSubMenu(null);
            }
        }

        return $this;
    }

    public function getPagina(): ?Pagina
    {
        return $this->pagina;
    }

    public function setPagina(Pagina $pagina): static
    {
        // set the owning side of the relation if necessary
        if ($pagina->getMenu() !== $this) {
            $pagina->setMenu($this);
        }

        $this->pagina = $pagina;

        return $this;
    }

    public function getMenuOrder(): ?int
    {
        return $this->menuOrder;
    }

    public function setMenuOrder(int $menuOrder): static
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }
}
