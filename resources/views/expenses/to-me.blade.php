<x-app-layout>

    <script>
        function reject(id){
            //alert(el.value+id)
            window.location.replace("/detach-user/"+id);
        }
        function pay(id){
            alert("PAGAR DESPESA " +id)
            //window.location.replace("/detach-user/"+id);
        }
    </script>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
    @foreach ( $expenses as $expense)
        <article class="w-80 p-2 text-sm bg-yellow-300 dark:bg-amber-800 overflow-hidden shadow-lg rounded-lg mx-auto px-4 hover:shadow-xl hover:transform hover:scale-105 duration-200">
                <div class="m-2 text-gray-900 dark:text-gray-100">
                    {{$expense->creditor->name}} - {{$expense->description}}<br>
                    R$ {{$expense->value}} - Vencimento: {{date('d/m/Y', strtotime($expense->due_date))}}
                </div>
                <div class="flex text-center p-2 z-0 w-full group">
                    <button class="bg-red-700 hover:bg-red-600 text-white mr-2 w-1/2 py-1 rounded-lg"
                            onclick="reject({{$expense->id}})">
                            {{ __('REJECT') }}</button>
                    <button class="bg-blue-900 hover:bg-blue-700 text-white ml-2 w-1/2 py-1 rounded-lg"
                            onclick="pay({{$expense->id}})">
                            {{ __('PAY') }}</button>
                </div>
        </article>
    @endforeach
    </div>

</x-app-layout>
