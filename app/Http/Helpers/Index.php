<?php

use Illuminate\Support\Facades\Request;

function isActive($path, $index = 2)
{
    return Request::segment($index) == $path ? true : false;
}

function paymentMethod($status)
{
    switch ($status) {
        case 'ba':
            return 'Bank Account';
        case 'cod':
            return 'Cash on Delivery';
        case 'cc':
            return 'Credit Card';
        case 'stripe':
            return 'Stripe';
        case 'check':
            return 'Check';
        default:
            return 'Bank Account';
    }
}
function paymentStatus($status)
{
    switch ($status) {
        case 'pending':
            return 'Pending';
        case 'paid':
            return 'Paid';
        case 'failed':
            return 'Failed';
        default:
            return 'Bank Account';
    }
}

function paymentStatusColor($status)
{
    switch ($status) {
        case 'pending':
            return 'bg-blue-500';
        case 'paid':
            return 'bg-green-600';
        case 'failed':
            return 'bg-red-700';
        default:
            return 'bg-blue-500';
    }
}

function status($status)
{
    switch ($status) {
        case 'new':
            return 'New';
        case 'processing':
            return 'Processing';
        case 'shipped':
            return 'Shipped';
        case 'delivered':
            return 'Delivered';
        case 'canceled':
            return 'Cancelled';
        default:
            return 'New';
    }
}

function statusColor($status)
{
    switch ($status) {
        case 'new':
            return 'bg-blue-500';
        case 'processing':
            return 'bg-yellow-500';
        case 'shipped':
            return 'bg-green-500';
        case 'delivered':
            return 'bg-green-700';
        case 'canceled':
            return 'bg-red-700';
        default:
            return 'bg-blue-500';
    }
}
