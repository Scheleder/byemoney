<x-app-layout>

    <script>
        function setaUser(el, id){
            //alert(el.value+id)
            window.location.replace("/attach-user/"+id+","+el.value);
        }
        function expand(){
            //alert("expand")
            document.getElementById("top").style.display = "none";
            document.getElementById("head").style.display = "block";
        }
        function collapse(){
            //alert("collapse")
            document.getElementById("top").style.display = "block";
            document.getElementById("head").style.display = "none";
        }
    </script>
    <div id="top" class="pl-4 w-full bg-white dark:bg-gray-800" >
        <svg class="w-4 h-6 text-gray-900 cursor-ns-resize" onclick="expand()" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
        </svg>
    </div>
    <div id="head" style="display:none" class="pt-4 grid grid-cols-1 justify-center text-center items-center bg-white dark:text-white dark:bg-gray-800 shadow">
        <div class="row">
            <div class="grid grid-cols-2 p-2 mb-2">
                <article class="mr-2 px-8 py-4 min-w-full bg-gray-50 dark:bg-gray-800 rounded border border-gray-50 dark:border-gray-800 shadow-2xl">
                    <img class="w-32" src="/img/pizza.png" alt="pizza">
                </article>
                <article class="ml-2 w-fit">
                        <div class="text-sm items-center text-center justify-center grid grid-cols-1">
                            <button class="w-40 m-1 h-8 bg-red-600 hover:bg-red-500 rounded">EXPORTAR PDF</button>
                            <button class="w-40 m-1 h-8 bg-orange-400 hover:bg-orange-300 rounded">HISTÓRICO</button>
                            <button type="button" data-modal-target="add-creditor-modal" data-modal-toggle="add-creditor-modal"
                                    class="w-40 m-1 h-8 bg-green-600 hover:bg-green-500 rounded">FORNECEDORES</button>
                            <button type="button" data-modal-target="add-expense-modal" data-modal-toggle="add-expense-modal"
                                    class="w-40 m-1 h-8 bg-blue-600 hover:bg-blue-500 rounded">NOVA DESPESA</button>
                        </div>
                </article>
            </div>
        </div>
        <div class="relative row">
            <svg class="bottom-1 left-4 absolute inline-flex w-4 h-6 cursor-ns-resize" onclick="collapse()" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
            </svg>
            <p class="text-xs text-right text-gray-800 dark:text-gray-300 mr-4 p-1">DESPESAS EM ABERTO: R$ {{ $expenses->sum('value') }}</p>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
    @foreach ( $expenses as $expense)
        <article class="w-80 p-2 text-sm bg-yellow-300 dark:bg-amber-800 overflow-hidden shadow-lg rounded-lg mx-auto px-4 hover:shadow-xl hover:transform hover:scale-105 duration-200">
                <div class="m-2 text-gray-900 dark:text-gray-100">
                    {{$expense->creditor->name}} - {{$expense->description}}<br>
                    R$ {{$expense->value}} - Vencimento: {{date('d/m/Y', strtotime($expense->due_date))}}
                </div>
                <div class="relative z-0 w-full group">
                    <select id="user_id" name="user_id" onchange="setaUser(this, {{$expense->id}})"
                        class="block py-1 px-3 w-full text-sm rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer
                            {{ $expense->user_id ? 'text-gray-900 dark:text-gray-300 bg-amber-600 dark:bg-gray-900 dark:border-gray-700 border-amber-500' : 'text-gray-800 dark:text-gray-400 bg-amber-100 dark:bg-amber-700 border-amber-200 dark:border-amber-900'}}">
                            <option class="py-1">Designar para...</option>
                            @foreach($users as $user)
                                <option class="py-1" value="{{ $user->id }}" {{ $expense->user_id == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                            @endforeach
                    </select>
                </div>
        </article>
    @endforeach
    </div>


<!-- Creditor modal -->
<div id="add-creditor-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="add-creditor-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-6 text-xl text-gray-900 dark:text-white">{{ __('New Creditor')}}</h3>
                <form class="space-y-6" action="/creditor/create" method="POST">
                    @csrf
                    @method('POST')

                    <div>
                        <label for="name" class="block mb-1 text-sm text-gray-900 dark:text-white">{{ __('Name')}}</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                        block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="{{ __('Name') }}" required>
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __('Add Creditor') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Expense modal -->
<div id="add-expense-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="add-expense-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-6 text-xl text-gray-900 dark:text-white">{{ __('New Expense')}}</h3>
                <form class="space-y-6" action="/expense/create" method="POST">
                    @csrf
                    @method('POST')
                    <div class="relative z-0 w-full mb-1 group">
                        <label for="creditor_id" class="block mb-1 text-sm text-gray-900 dark:text-white">{{ __('Creditor')}}</label>
                        <select id="creditor_id" name="creditor_id" required
                            class="block py-2.5 px-3 w-full text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded-lg appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    <option class="py-1" value="" selected>Selecione...</option>
                                @foreach ( $creditors as $creditor)
                                    <option class="py-1" value="{{$creditor->id}}">{{ $creditor->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="description" class="block mb-1 text-sm text-gray-900 dark:text-white">{{ __('Description')}}</label>
                        <input type="text" name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                        block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Conta..." required>
                    </div>
                    <div>
                        <label for="value" class="block mb-1 text-sm text-gray-900 dark:text-white">{{ __('Value') }}</label>
                        <input type="text" name="value" id="value" placeholder="0.00" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div class="relative z-0 w-full mb-1 group">
                        <label class="block mb-1 text-sm text-gray-900 dark:text-white" for="due_date">{{ __('Due Date') }}</label>
                        <input
                        class="dark:[color-scheme:dark] mb-4 text-sm p-2.5 w-full border border-gray-300 dark:border-gray-500 bg-gray-50 dark:bg-gray-600 dark:text-white rounded-lg"
                        type="date" id="due_date" name="due_date" value="{{now()}}" required>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __('Add Expense') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
