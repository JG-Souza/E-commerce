<x-app-layout>
    <div class="bg-gray-100 flex items-center justify-center overflow-hidden mt-40">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Entre em Contato</h2>
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 font-medium">Nome</label>
                    <input type="text" id="name" name="name" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-medium">E-mail</label>
                    <input type="email" id="email" name="email" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-gray-600 font-medium">Assunto</label>
                    <input type="text" id="subject" name="subject" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-600 font-medium">Mensagem</label>
                    <textarea id="message" name="message" rows="4" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600 transition">Enviar</button>
            </form>
        </div>
    </div>
</x-app-layout>
