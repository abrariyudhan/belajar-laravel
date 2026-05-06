import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function Create({ categories }) {
    const { data, setData, post, processing, errors } = useForm({
        date: new Date().toISOString().split('T')[0],
        amount: '',
        type: 'expense',
        category_id: '',
        description: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('transactions.store'));
    };

    return (
        <AuthenticatedLayout header={<h2 className="text-xl font-semibold">Tambah Transaksi</h2>}>
            <Head title="Tambah Transaksi" />
            <div className="py-12">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="bg-white p-6 shadow sm:rounded-lg">
                        <form onSubmit={submit} className="space-y-4">
                            {/* Input Tanggal */}
                            <div>
                                <label className="block text-sm font-medium">Tanggal</label>
                                <input type="date" value={data.date} onChange={e => setData('date', e.target.value)} className="w-full rounded-md border-gray-300" />
                                {errors.date && <div className="text-red-500 text-sm">{errors.date}</div>}
                            </div>

                            {/* Input Jumlah */}
                            <div>
                                <label className="block text-sm font-medium">Jumlah (IDR)</label>
                                <input type="number" value={data.amount} onChange={e => setData('amount', e.target.value)} placeholder="Contoh: 50000" className="w-full rounded-md border-gray-300" />
                                {errors.amount && <div className="text-red-500 text-sm">{errors.amount}</div>}
                            </div>

                            {/* Select Kategori */}
                            <div>
                                <label className="block text-sm font-medium">Kategori</label>
                                <select 
                                    value={data.category_id} 
                                    onChange={e => setData('category_id', e.target.value)}
                                    className="w-full rounded-md border-gray-300"
                                >
                                    <option value="">Pilih Kategori</option>
                                    {categories.map(cat => (
                                        <option key={cat.id} value={cat.id}>{cat.name} ({cat.type})</option>
                                    ))}
                                </select>
                                {errors.category_id && <div className="text-red-500 text-sm">{errors.category_id}</div>}
                            </div>

                            {/* Select Tipe */}
                            <div>
                                <label className="block text-sm font-medium">Tipe</label>
                                <select value={data.type} onChange={e => setData('type', e.target.value)} className="w-full rounded-md border-gray-300">
                                    <option value="expense">Pengeluaran</option>
                                    <option value="income">Pemasukan</option>
                                </select>
                            </div>

                            {/* Deskripsi */}
                            <div>
                                <label className="block text-sm font-medium">Keterangan</label>
                                <textarea value={data.description} onChange={e => setData('description', e.target.value)} className="w-full rounded-md border-gray-300"></textarea>
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <Link href={route('transactions.index')} className="mr-4 text-gray-600">Batal</Link>
                                <button type="submit" disabled={processing} className="bg-blue-600 text-white px-4 py-2 rounded-md">
                                    Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}