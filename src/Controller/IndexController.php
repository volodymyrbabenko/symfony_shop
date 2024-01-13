<?php

namespace App\Controller;

use App\Entity\ShopItems;
use App\Entity\ShopCart;
use App\Entity\ShopOrder;
use App\Form\OrderFormType;
use App\Repository\ShopCartRepository;
use App\Repository\ShopItemsRepository;
use App\ValueObject\ShopCartId;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    private SessionInterface $session;

    /**
     * @param SessionInterface $session
     */

    public function __construct(private RequestStack $requestStack)
    {
        $this->session = $this->requestStack->getSession();
        $this->session->set('attribute-name', 'attribute-value');
    }

    #[Route('/', name: 'index')]
    public function index(ShopItemsRepository $itemsRepository): Response
    {
        $items = $itemsRepository->findAll();

        // dd($items);

        return $this->render('index/index.html.twig', [
            'title' => 'SHOP LIST',
            'items' => $items
        ]);

    }


    #[Route('/shop/cart/add/{id<\d+>}', name: 'shopCartAdd')]
    public function shopCartAdd(int $id, ShopItemsRepository $shopItemsRepository, ShopCartRepository $cartRepository, EntityManagerInterface $em)
    {
        $sessionId = $this->session->getId();
        // dd($sessionId);

        $shopItem = $shopItemsRepository->findOneBy(['id' => $id]);
        $cart = $cartRepository->findOneBy(['sessionId' => $sessionId, 'shopItem' => $shopItem]);
        //dd($cart->getCount());
        //dd(ShopCartId::generateRandom());

        if($cart instanceOf ShopCart  AND $cart->getCount() != 0) {
            $count = $cart->getCount() + 1;
            $cart->setCount($count);
            //$cart->setId(ShopCartId::generateRandom());
            $em->persist($cart);
            $em->flush();
        }
        else {
            $count = 1;

            $shopCart = (new ShopCart())
                ->setShopItem($shopItem)
                ->setCount($count)
                ->setSessionId($sessionId);

            $shopCart->setId(ShopCartId::generateRandom());
            $em->persist($shopCart);
            $em->flush();
        }

        //return $this->redirectToRoute('shopItem', ['id' => $shopItem->getId()]);
        return $this->redirectToRoute('shopCart');
    }

	#[Route('/shop/item/{id<\d+>}', name: 'shopItem')]
	public function shopItem(int $id, ShopItemsRepository $shopItemsRepository): Response
	{
		$shopItem = $shopItemsRepository->findOneBy(['id' => $id]);
		return $this->render('index/shopItem.html.twig', [
			'title' => $shopItem->getTitle(),
			'description' => $shopItem->getDescription(),
			'price' => $shopItem->getPrice(),
			'id' => $shopItem->getId(),
		]);
	}

    #[Route('/shop/cart', name: 'shopCart')]
    public function shopCart(ShopCartRepository $cartRepository): Response
    {
        $session = $this->session->getId();
        $items = $cartRepository->findBy(['sessionId' => $session], ['id' => 'ASC']);

        //dd($cart);

        return $this->render('index/shopCart.html.twig', [
            'title' => 'Cart',
            'items' => $items,
        ]);
    }

    #[Route('/shop/order', name: 'shopOrder')]
    public function shopOrder(Request $request, EntityManagerInterface $em): Response
    {
        // just set up a fresh $task object (remove the example data)
        $shopOrder = new ShopOrder();

        $form = $this->createForm(OrderFormType::class, $shopOrder);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shopOrder = $form->getData();

            if($shopOrder instanceof ShopOrder) {
                $sessionId = $this->session->getId();
                $shopOrder -> setStatus(ShopOrder::STATUS_NEW_ORDER);
                $shopOrder -> setSessionId($sessionId);
                //dd($shopOrder);
                $em->persist($shopOrder);
                $em->flush();
                //session_regenerate_id
                $this->session->migrate();
            }

            return $this->redirectToRoute('index');
        }

        return $this->render('index/shopOrder.html.twig', [
            'title' => 'Checkout',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/shop/cart/delete/{id}', name: 'shopCartDelete')]
    public function shopCartDelete(string $id, ShopCartRepository $cartRepository, EntityManagerInterface $em)
    {
        $shopItem = $cartRepository->findOneBy(['id' => $id]);
        $em->remove($shopItem);
        $em->flush();

        return $this->redirectToRoute('shopCart');
    }

    #[Route('/shop/cart/addProduct/{id}', name: 'shopCartPlus')]
    public function shopCartPlus(string $id, ShopCartRepository $cartRepository, EntityManagerInterface $em)
    {
        //dd($id);

        $cart = $cartRepository->findOneBy(['id' => $id]);

        if($cart instanceOf ShopCart  AND $cart->getCount() != 0) {
            $count = $cart->getCount() + 1;
            $cart->setCount($count);
            $em->persist($cart);
            $em->flush();
        }

        return $this->redirectToRoute('shopCart');
    }

    #[Route('/shop/cart/putAwayProduct/{id}', name: 'shopCartMinus')]
    public function shopCartMinus(string $id, ShopCartRepository $cartRepository, EntityManagerInterface $em)
    {
        //dd($id);

        $cart = $cartRepository->findOneBy(['id' => $id]);

        if($cart instanceOf ShopCart  AND $cart->getCount() != 0) {
            $count = $cart->getCount() - 1;
            if($count != 0) {
                $cart->setCount($count);
                $em->persist($cart);
                $em->flush();
            }
            else {
                $em->remove($cart);
                $em->flush();
            }
        }

        return $this->redirectToRoute('shopCart');
    }
}
