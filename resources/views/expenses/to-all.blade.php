<x-app-layout>
    
    <script>
        function setaUser(el, id){
            //alert(el.value+id)
            window.location.replace("/attach-user/"+id+","+el.value);
        }
    </script>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
    @foreach ( $expenses as $expense)
        <article class="p-2 text-sm bg-amber-200 dark:bg-amber-800 overflow-hidden shadow-lg rounded-lg mx-auto px-4 hover:shadow-xl hover:transform hover:scale-105 duration-200">
                <div class="m-2 text-gray-900 dark:text-gray-100">
                    {{$expense->creditor->name}} - {{$expense->description}}<br>
                    R$ {{$expense->value}} - Vencimento: {{date('d/m/Y', strtotime($expense->due_date))}}
                </div>
                <div class="relative z-0 w-full group">
                    <select id="user_id" name="user_id" onchange="setaUser(this, {{$expense->id}})"
                        class="block py-1 px-3 w-full text-sm rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer
                            {{ $expense->user_id ? 'text-gray-900 dark:text-gray-300 bg-gray-300 dark:bg-gray-900 dark:border-gray-700 border-gray-300' : 'text-gray-800 dark:text-gray-400 bg-amber-100 dark:bg-amber-700 border-amber-200 dark:border-amber-900'}}">
                            <option class="py-1">Designar para...</option>
                            @foreach($users as $user)
                                <option class="py-1" value="{{ $user->id }}" {{ $expense->user_id == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                            @endforeach
                    </select>
                </div>
        </article>
    @endforeach
    </div>

</x-app-layout>
