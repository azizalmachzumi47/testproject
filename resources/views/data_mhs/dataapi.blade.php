@extends('layouts.app')

@section('title', 'Data API Mahasiswa')

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <a href="https://cors-anywhere.herokuapp.com/corsdemo" target="_blank" class="btn btn-success mb-3">
            Aktifkan Akses Proxy
        </a>
        <button onclick="saveToDatabase()" class="btn btn-primary mb-3" id="btn-save" disabled>
            Tambahkan ke Database
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="table-container">Memuat data...</div>
        </div>
    </div>
</div>

<script>
    let parsedData = [];

    async function fetchData() {
        const proxy = 'https://cors-anywhere.herokuapp.com/';
        const url = 'https://ogienurdiana.com/career/ecc694ce4e7f6e45a5a7912cde9fe131';

        try {
            const res = await fetch(proxy + url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const text = await res.text();
            const response = JSON.parse(text);

            if (response.RC === 200) {
                parsedData = parseData(response.DATA);
                document.getElementById('table-container').innerHTML = generateTable(parsedData);
                document.getElementById('btn-save').disabled = false;
            } else {
                document.getElementById('table-container').innerText = 'Gagal memuat data.';
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('table-container').innerText = 'Terjadi kesalahan saat mengambil data.';
        }
    }

    function parseData(dataStr) {
        const rows = dataStr.trim().split('\n');
        const result = [];
        rows.forEach((row, index) => {
            if (index === 0) return;
            const [nim, nama, ymd] = row.split('|');
            const formattedDate = `${ymd.slice(0, 4)}-${ymd.slice(4, 6)}-${ymd.slice(6, 8)}`;
            result.push({ nim, nama, tanggal: formattedDate });
        });
        return result;
    }

    function generateTable(data) {
        let html = '<table>';
        html += '<tr><th>NIM</th><th>Nama</th><th>Tanggal</th></tr>';
        data.forEach(item => {
            html += `<tr><td>${item.nim}</td><td>${item.nama}</td><td>${item.tanggal}</td></tr>`;
        });
        html += '</table>';
        return html;
    }

    function saveToDatabase() {
        console.log("Sending data:", parsedData);

        document.getElementById('btn-save').innerText = 'Menyimpan...';
        document.getElementById('btn-save').disabled = true;

        fetch('{{ route('data_mhs.savedataapi') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ data: parsedData })
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message);
            window.location.href = result.redirect;
        })
        .catch(error => {
            console.error('Error saat menyimpan:', error);
            alert('Gagal menyimpan data.');
        });
    }

    fetchData();
</script>
@endsection
