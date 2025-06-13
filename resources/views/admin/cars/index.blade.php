@extends('layouts.app')

@section('content')
<div class="container my-5">

    <h2 class="mb-4 text-center fw-bold">ระบบจัดการรถ</h2>

    <div class="row">
        <!-- ฟอร์ม -->
        <div class="col-md-5">
            <h5 id="formTitle" class="mb-3">เพิ่มรถใหม่</h5>
            <form id="carForm">
                <input type="hidden" id="carId">
                
                <div class="mb-3">
                    <label class="form-label">ยี่ห้อ (Brand)</label>
                    <input type="text" class="form-control" id="brand" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">รุ่น (Model)</label>
                    <input type="text" class="form-control" id="model" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">ปีที่ผลิต (Year)</label>
                    <input type="number" class="form-control" id="year" required>
                </div>

                <button type="submit" class="btn btn-success w-100" id="submitBtn">เพิ่มรถ</button>
                <button type="button" class="btn btn-outline-secondary w-100 mt-2 d-none" id="cancelEditBtn">ยกเลิกการแก้ไข</button>
            </form>
        </div>

        <!-- รายการรถ -->
        <div class="col-md-7">
            <h5 class="mb-3">รายการรถทั้งหมด</h5>
            <ul class="list-group" id="carList">
                @foreach ($cars as $car)
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $car->id }}">
                        <span>{{ $car->brand }} - {{ $car->model }} - {{ $car->year }}</span>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning edit-btn"
                                data-id="{{ $car->id }}"
                                data-brand="{{ $car->brand }}"
                                data-model="{{ $car->model }}"
                                data-year="{{ $car->year }}">แก้ไข</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $car->id }}">ลบ</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carForm = document.getElementById('carForm');
    const carList = document.getElementById('carList');
    const carIdInput = document.getElementById('carId');
    const brandInput = document.getElementById('brand');
    const modelInput = document.getElementById('model');
    const yearInput = document.getElementById('year');
    const submitBtn = document.getElementById('submitBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const formTitle = document.getElementById('formTitle');

    carForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const carId = carIdInput.value;
        const url = carId ? `/admin/cars/${carId}` : `/admin/cars`;
        const method = carId ? 'PUT' : 'POST';

        const formData = new FormData();
        formData.append('brand', brandInput.value);
        formData.append('model', modelInput.value);
        formData.append('year', yearInput.value);
        if (carId) formData.append('_method', 'PUT');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (carId) {
                const li = carList.querySelector(`li[data-id="${carId}"]`);
                li.querySelector('span').textContent = `${data.brand} - ${data.model} - ${data.year}`;
                li.querySelector('.edit-btn').dataset.brand = data.brand;
                li.querySelector('.edit-btn').dataset.model = data.model;
                li.querySelector('.edit-btn').dataset.year = data.year;
            } else {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.dataset.id = data.id;
                li.innerHTML = `
                    <span>${data.brand} - ${data.model} - ${data.year}</span>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning edit-btn"
                            data-id="${data.id}"
                            data-brand="${data.brand}"
                            data-model="${data.model}"
                            data-year="${data.year}">แก้ไข</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">ลบ</button>
                    </div>`;
                carList.appendChild(li);
            }

            carForm.reset();
            carIdInput.value = '';
            submitBtn.textContent = 'เพิ่มรถ';
            cancelEditBtn.classList.add('d-none');
            formTitle.textContent = 'เพิ่มรถใหม่';
        });
    });

    carList.addEventListener('click', function(e) {
        const btn = e.target;
        if (btn.classList.contains('edit-btn')) {
            carIdInput.value = btn.dataset.id;
            brandInput.value = btn.dataset.brand;
            modelInput.value = btn.dataset.model;
            yearInput.value = btn.dataset.year;

            formTitle.textContent = 'แก้ไขข้อมูลรถ';
            submitBtn.textContent = 'บันทึกการแก้ไข';
            cancelEditBtn.classList.remove('d-none');
        }

        if (btn.classList.contains('delete-btn')) {
            if (!confirm('ยืนยันการลบรถคันนี้?')) return;
            const id = btn.dataset.id;

            fetch(`/admin/cars/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                btn.closest('li').remove();
            });
        }
    });

    cancelEditBtn.addEventListener('click', () => {
        carForm.reset();
        carIdInput.value = '';
        submitBtn.textContent = 'เพิ่มรถ';
        cancelEditBtn.classList.add('d-none');
        formTitle.textContent = 'เพิ่มรถใหม่';
    });
});
</script>
@endsection
