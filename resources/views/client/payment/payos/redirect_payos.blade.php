<form id="payosForm" action="{{ route('payos.payment', ['order_id' => $order_id]) }}" method="POST">
    @csrf
</form>
<script>
    document.getElementById('payosForm').submit();
</script>