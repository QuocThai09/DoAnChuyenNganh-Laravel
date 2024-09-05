
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<form onsubmit="return false">
    @csrf
    <input class="input-search" type="text" id="nameKH" placeholder="Họ tên Khách Hàng ..." list="dataKH">
    <datalist id="dataKH">
        @foreach ($dskh as $item)
            <option value="{{$item->HOTENKH}}"></option>
        @endforeach
    </datalist>
    <button type="submit" class="btn-search" id="search">
        <svg width="25" height="25" fill="#2183de" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14.385 15.446a6.751 6.751 0 1 1 1.06-1.06l5.156 5.155a.75.75 0 1 1-1.06 1.06l-5.156-5.155ZM6.46 13.884a5.25 5.25 0 1 1 7.43-.005l-.005.005-.005.004a5.25 5.25 0 0 1-7.42-.004Z" clip-rule="evenodd"></path>
        </svg>
    </button>
</form>
<div id="danhsachcheckin"></div>
<script>
    document.getElementById('search').addEventListener('click', () => {
            var _token = $('input[name="_token"]').val();
            var nameKH = document.getElementById('nameKH').value;
            if(nameKH == ''){
                alert('Vui lòng nhập tên khách hàng');
            }
            $.ajax({
                    url: "{{ url('admin/test') }}",
                    method: "POST",
                    data: { nameKH: nameKH,_token:_token },
                    success: function (data) {
                        $("#danhsachcheckin").html(data);
                    }
                });
        })
</script>