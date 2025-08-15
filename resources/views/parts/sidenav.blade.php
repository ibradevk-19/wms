<div class="two-col-sidebar" id="two-col-sidebar">
		
			<div class="sidebar" id="sidebar-two">

				<!-- Start Logo -->
				<div class="sidebar-logo">
					<a href="index.html" class="logo logo-normal">
						<img src="{{asset('assets-v1/assets/img/logo.png')}}" style="width: 60px;" alt="Logo">
					</a>
					<a href="index.html" class="logo-small">
						<img src="{{asset('assets-v1/assets/img/logo.png')}}" style="width: 60px;" alt="Logo">
					</a>
					<a href="index.html" class="dark-logo">
						<img src="{{asset('assets-v1/assets/img/logo.png')}}" style="width: 60px;" alt="Logo">
					</a>
					<a href="index.html" class="dark-small">
						<img src="{{asset('assets-v1/assets/img/logo.png')}}" style="width: 60px;" alt="Logo">
					</a>
					
					<!-- Sidebar Hover Menu Toggle Button -->
					
				</div>
				<!-- End Logo -->
						
				<!-- Search -->
				
				<!-- /Search -->

				<!--- Sidenav Menu -->
		
<div class="sidebar-inner" data-simplebar>
  <div id="sidebar-menu" class="sidebar-menu">
    <ul>
      {{-- 🏠 الرئيسية --}}
      <li><a href="{{ route('dashboard') }}">🏠 الرئيسية</a></li>

      {{-- 🏬 إدارة المخازن --}}
      <li class="menu-title">المخازن</li>
      <li><a href="{{ route('warehouses.index') }}">🏬 قائمة المخازن</a></li>
      <li><a href="{{ route('warehouses.create') }}">➕ إضافة مخزن</a></li>

      {{-- 📦 إدارة الأصناف --}}
      <li class="menu-title">الأصناف</li>
      <li><a href="{{ route('products.index') }}">📦 الأصناف</a></li>
      <li><a href="{{ route('categories.index') }}">📁 التصنيفات</a></li>
      <li><a href="{{ route('units.index') }}">📏 وحدات القياس</a></li>

      {{-- 🧾 فواتير المخزون --}}
      <li class="menu-title">الفواتير</li>
      <li><a href="{{ route('supply_invoices.create') }}">📥 فاتورة توريد</a></li>
      <li><a href="{{ route('issue-invoices.create') }}">📤 فاتورة صرف</a></li>
      <li><a href="{{ route('transfer_vouchers.create') }}">🔄 فاتورة تحويل</a></li>

      {{-- 🧮 الجرد والتعديل --}}
      <li class="menu-title">الجرد</li>
      <li><a href="{{ route('inventory.adjustment.create', 1) }}">🧮 تعديل مخزون</a></li>

      {{-- 📊 التقارير --}}
      <li class="menu-title">التقارير</li>
      <li><a href="{{ route('reports.low-stock') }}">⚠️ الأصناف منخفضة</a></li>
      <li><a href="{{ route('reports.stock-summary') }}">📄 ملخص المخزون</a></li>
      <li><a href="{{ route('reports.warehouse-stock') }}">🏪 رصيد المخزون بالمخازن</a></li>
      <li><a href="{{ route('warehouse.reports.index') }}">📈 تقارير المخازن</a></li>

      {{-- ⚙️ إدارة المستخدمين (حسب الصلاحية) --}}
      @role('admin')
        <li class="menu-title">النظام</li>
        <li><a href="{{ route('users.index') }}">👤 إدارة المستخدمين</a></li>
      @endrole

      {{-- 👤 الملف الشخصي --}}
      <li class="menu-title">الحساب</li>
      <li><a href="{{ route('profile.edit') }}">👤 الملف الشخصي</a></li>
      <li>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          🚪 تسجيل الخروج
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </li>
    </ul>
  </div>
</div>


			</div>
		</div>