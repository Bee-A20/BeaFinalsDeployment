<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(
        ProductsRepository $productsRepository,
        CustomerRepository $customerRepository,
        OrdersRepository $ordersRepository
    ): Response
    {
        // Get counts
        $totalProducts = count($productsRepository->findAll());
        $totalCustomers = count($customerRepository->findAll());
        $totalOrders = count($ordersRepository->findAll());
        
        // Calculate revenue from orders excluding cancelled ones
        $orders = $ordersRepository->findAll();
        $revenue = 0.0;
        foreach ($orders as $order) {
            $status = $order->getStatus();
            if (null === $status || strtolower($status) !== 'delivered') {
                continue; // count only delivered orders as actual revenue
            }

            $revenue += $order->getTotal();
        }
        
        $response = $this->render('dashboard/index.html.twig', [
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalOrders' => $totalOrders,
            'revenue' => $revenue,
        ]);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
