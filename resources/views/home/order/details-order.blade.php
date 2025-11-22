<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Order Details</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left: Items -->
    <section class="lg:col-span-2">
      <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-xl font-semibold">Order #ORDER_NUMBER</h1>
            <p class="text-sm text-gray-500 mt-1">Placed on ORDER_DATE — Status: <span class="font-medium">STATUS</span></p>
          </div>
          <div class="text-right">
            <h2 class="text-sm text-gray-600">Total</h2>
            <div class="text-lg font-semibold">Total Amount</div>
          </div>
        </div>

        <div class="divide-y divide-gray-100 mt-6">
          <!-- Repeatable product row -->
          <div class="py-4 flex items-start gap-4">
            <div class="w-20 h-20 bg-gray-50 rounded-md flex items-center justify-center">
              <img src="https://via.placeholder.com/80" alt="Product" class="object-cover w-full h-full rounded">
            </div>
            <div class="flex-1">
              <h3 class="font-medium">Product Title</h3>
              <p class="text-sm text-gray-500 mt-1">Short product description</p>
              <div class="mt-3 flex items-center justify-between text-sm text-gray-700">
                <div>Qty: <span class="font-medium">1</span></div>
                <div>Unit: <span class="font-medium">Price</span></div>
                <div>Subtotal: <span class="font-semibold">Subtotal</span></div>
              </div>
            </div>
          </div>
          <!-- end product row -->
        </div>
      </div>
    </section>

    <!-- Right: Summary / Shipping -->
    <aside>
      <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div>
          <h2 class="text-sm text-gray-600">Shipping To</h2>
          <div class="mt-1 font-medium">Name</div>
          <div class="text-sm text-gray-500">Address</div>
        </div>

        <div>
          <h2 class="text-sm text-gray-600">Payment Method</h2>
          <div class="mt-1 font-medium">Payment Method</div>
        </div>

        <div class="pt-2 border-t border-gray-100">
          <div class="flex justify-between text-sm text-gray-600">
            <div>Subtotal</div>
            <div>Subtotal Amount</div>
          </div>
          <div class="flex justify-between text-sm text-gray-600 mt-1">
            <div>Shipping</div>
            <div>Shipping Cost</div>
          </div>
          <div class="flex justify-between text-sm text-gray-600 mt-1">
            <div>Tax</div>
            <div>Tax Amount</div>
          </div>
          <div class="flex justify-between text-lg font-semibold mt-4">
            <div>Total</div>
            <div>Total Amount</div>
          </div>
        </div>

        <div class="pt-2">
          <a href="/order/print" class="block text-center py-2 border rounded-md text-sm hover:bg-gray-50">Print Receipt</a>
          <a href="/orders" class="block text-center mt-2 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Back to Orders</a>
        </div>
      </div>
    </aside>
  </div>
</body>
</html>