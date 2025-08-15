
@extends('layouts.master')
@section('page-title')
  لوحة التحكم
@endsection

@section('content')

<div class="row">

  <div class="col-md-4 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <h6 class="mb-3"><i class="isax isax-chart-215 text-default me-2"></i>إحصائيات محاسبية</h6>
        <div class="row g-4">
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                <i class="isax isax-document-text-1 fs-20"></i>
              </span>
              <div>
                <p class="mb-1">عدد القيود اليومية</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                <i class="isax isax-dollar-circle fs-20"></i>
              </span>
              <div>
                <p class="mb-1">إجمالي الإيرادات</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                <i class="isax isax-wallet-check fs-20"></i>
              </span>
              <div>
                <p class="mb-1">إجمالي المصروفات</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                <i class="isax isax-coin fs-20"></i>
              </span>
              <div>
                <p class="mb-1">صافي الربح</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 🔹 قسم الموارد البشرية --}}
  <div class="col-md-4 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <h6 class="mb-3"><i class="isax isax-profile-2user text-default me-2"></i>الموارد البشرية</h6>
        <div class="row g-4">
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                <i class="isax isax-user fs-20"></i>
              </span>
              <div>
                <p class="mb-1">عدد الموظفين</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                <i class="isax isax-calendar fs-20"></i>
              </span>
              <div>
                <p class="mb-1">إجمالي الحضور اليوم</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                <i class="isax isax-money fs-20"></i>
              </span>
              <div>
                <p class="mb-1">رواتب هذا الشهر</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                <i class="isax isax-star fs-20"></i>
              </span>
              <div>
                <p class="mb-1">عدد التقييمات</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 🔹 قسم المستفيدين --}}
  <div class="col-md-4 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <h6 class="mb-3"><i class="isax isax-people text-default me-2"></i>إدارة المستفيدين</h6>
        <div class="row g-4">
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-primary-subtle text-primary flex-shrink-0 me-2">
                <i class="isax isax-user fs-20"></i>
              </span>
              <div>
                <p class="mb-1">إجمالي المستفيدين</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-success-subtle text-success-emphasis flex-shrink-0 me-2">
                <i class="isax isax-hierarchy-square-2 fs-20"></i>
              </span>
              <div>
                <p class="mb-1">عدد المشاريع النشطة</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-warning-subtle text-warning-emphasis flex-shrink-0 me-2">
                <i class="isax isax-document-text fs-20"></i>
              </span>
              <div>
                <p class="mb-1">عدد التوزيعات</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="d-flex align-items-center">
              <span class="avatar avatar-44 avatar-rounded bg-info-subtle text-info-emphasis flex-shrink-0 me-2">
                <i class="isax isax-folder-open fs-20"></i>
              </span>
              <div>
                <p class="mb-1">التقارير المرفوعة</p>
                <h6 class="fs-16 fw-semibold"></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div> <!-- end row -->

@endsection
