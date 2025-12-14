<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OpenStackInstance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search for customers and instances.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $query = trim($query);

        if (empty($query)) {
            return response()->json([
                'customers' => [],
                'instances' => [],
            ]);
        }

        // Search customers
        $customers = Customer::query()
            ->search($query)
            ->limit(5)
            ->get()
            ->map(function ($customer) use ($query) {
                return [
                    'id' => $customer->id,
                    'name' => $this->highlightText($customer->full_name, $query),
                    'email' => $this->highlightText($customer->email ?? '', $query),
                    'phone' => $this->highlightText($customer->phone_number ?? '', $query),
                    'company' => $this->highlightText($customer->company_name ?? '', $query),
                    'status' => $customer->status,
                    'raw_name' => $customer->full_name,
                    'raw_email' => $customer->email,
                    'raw_phone' => $customer->phone_number,
                    'raw_company' => $customer->company_name,
                    'url' => route('admin.users.index', ['search' => $query]),
                ];
            });

        // Search instances
        $instances = OpenStackInstance::query()
            ->with('customer')
            ->notDeleted()
            ->search($query)
            ->limit(5)
            ->get()
            ->map(function ($instance) use ($query) {
                return [
                    'id' => $instance->id,
                    'name' => $this->highlightText($instance->name, $query),
                    'description' => $this->highlightText($instance->description ?? '', $query),
                    'status' => $instance->status,
                    'region' => $instance->region,
                    'customer_name' => $this->highlightText($instance->customer->full_name ?? '', $query),
                    'raw_name' => $instance->name,
                    'raw_description' => $instance->description,
                    'raw_customer_name' => $instance->customer->full_name ?? '',
                    'url' => route('admin.compute.show', $instance->id),
                ];
            });

        return response()->json([
            'customers' => $customers,
            'instances' => $instances,
        ]);
    }

    /**
     * Highlight search terms in text.
     *
     * @param string|null $text
     * @param string $query
     * @return string
     */
    private function highlightText(?string $text, string $query): string
    {
        if (empty($text)) {
            return '';
        }

        $query = preg_quote($query, '/');
        $pattern = "/({$query})/i";
        $replacement = '<mark>$1</mark>';

        return preg_replace($pattern, $replacement, $text);
    }
}

