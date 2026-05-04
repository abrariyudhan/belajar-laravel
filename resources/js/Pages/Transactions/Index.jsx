import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({ transactions }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Daftar Transaksi
                </h2>
            }
        >
            <Head title="Transactions" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 className="mb-4 text-lg font-medium">Riwayat Keuangan</h3>
                        
                        <div className="overflow-x-auto">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="border-b bg-gray-50">
                                        <th className="py-3 px-4">Tanggal</th>
                                        <th className="py-3 px-4">Keterangan</th>
                                        <th className="py-3 px-4">Kategori</th>
                                        <th className="py-3 px-4">Tipe</th>
                                        <th className="py-3 px-4">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {transactions.length > 0 ? (
                                        transactions.map((item) => (
                                            <tr key={item.id} className="border-b hover:bg-gray-50">
                                                <td className="py-3 px-4">{item.date}</td>
                                                <td className="py-3 px-4">{item.description || '-'}</td>
                                                <td className="py-3 px-4">
                                                    <span className="px-2 py-1 bg-gray-100 rounded-md text-sm text-gray-600">
                                                        {item.category}
                                                    </span>
                                                </td>
                                                <td className="py-3 px-4 uppercase text-xs font-bold">
                                                    <span className={item.type === 'income' ? 'text-green-600' : 'text-red-600'}>
                                                        {item.type === 'income' ? 'Pemasukan' : 'Pengeluaran'}
                                                    </span>
                                                </td>
                                                <td className={`py-3 px-4 text-right font-semibold ${item.type === 'income' ? 'text-green-700' : 'text-red-700'}`}>
                                                    {item.type === 'expense' ? '- ' : '+ '}
                                                    {new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.amount)}
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan="5" className="py-10 text-center text-gray-500 italic">
                                                Belum ada data transaksi. Silahkan tambah transaksi baru.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}