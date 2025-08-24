import { useState } from "react";
import { Head } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {
    Search,
    Plus,
    Filter,
    Eye,
    Pencil,
    Trash2,
    ChevronLeft,
    ChevronRight,
} from "lucide-react";

// Dummy data for the enterprise table
const enterprises = [
    {
        id: 1,
        photo: "https://placehold.co/40x40/f43f5e/fff?text=T",
        name: "TechCorp Solutions",
        enterpriseId: "ENT001",
        sector: "Technology",
        location: "Paris",
        type: "SAS",
        status: "Active",
    },
    {
        id: 2,
        photo: "https://placehold.co/40x40/3b82f6/fff?text=F",
        name: "FinancePlus Group",
        enterpriseId: "ENT002",
        sector: "Finance",
        location: "Lyon",
        type: "SARL",
        status: "Active",
    },
    {
        id: 3,
        photo: "https://placehold.co/40x40/16a34a/fff?text=C",
        name: "Consulting Experts",
        enterpriseId: "ENT003",
        sector: "Consulting",
        location: "Marseille",
        type: "SAS",
        status: "Active",
    },
    {
        id: 4,
        photo: "https://placehold.co/40x40/6366f1/fff?text=D",
        name: "Digital Innovations",
        enterpriseId: "ENT004",
        sector: "Technology",
        location: "Toulouse",
        type: "SAS",
        status: "Active",
    },
    {
        id: 5,
        photo: "https://placehold.co/40x40/f97316/fff?text=S",
        name: "ServiceMaster Pro",
        enterpriseId: "ENT005",
        sector: "Services",
        location: "Nantes",
        type: "SARL",
        status: "Active",
    },
    {
        id: 6,
        photo: "https://placehold.co/40x40/ef4444/fff?text=J",
        name: "Jewelry & Co",
        enterpriseId: "ENT006",
        sector: "Retail",
        location: "Bordeaux",
        type: "SAS",
        status: "Active",
    },
    {
        id: 7,
        photo: "https://placehold.co/40x40/22c55e/fff?text=M",
        name: "Manufacturing Plus",
        enterpriseId: "ENT007",
        sector: "Manufacturing",
        location: "Strasbourg",
        type: "SAS",
        status: "Active",
    },
    {
        id: 8,
        photo: "https://placehold.co/40x40/8b5cf6/fff?text=B",
        name: "BuildTech Solutions",
        enterpriseId: "ENT008",
        sector: "Construction",
        location: "Nice",
        type: "SARL",
        status: "Active",
    },
    {
        id: 9,
        photo: "https://placehold.co/40x40/f43f5e/fff?text=K",
        name: "Kitchen & Dining",
        enterpriseId: "ENT009",
        sector: "Restaurant",
        location: "Montpellier",
        type: "SAS",
        status: "Active",
    },
    {
        id: 10,
        photo: "https://placehold.co/40x40/3b82f6/fff?text=K",
        name: "Knowledge Hub",
        enterpriseId: "ENT010",
        sector: "Education",
        location: "Rennes",
        type: "SAS",
        status: "Active",
    },
    {
        id: 11,
        photo: "https://placehold.co/40x40/16a34a/fff?text=A",
        name: "AutoMotive Pro",
        enterpriseId: "ENT011",
        sector: "Automotive",
        location: "Lille",
        type: "SARL",
        status: "Active",
    },
    {
        id: 12,
        photo: "https://placehold.co/40x40/6366f1/fff?text=D",
        name: "Design Studio",
        enterpriseId: "ENT012",
        sector: "Design",
        location: "Grenoble",
        type: "SAS",
        status: "Active",
    },
];

export default function EnterprisesIndex({ auth }) {
    const [currentPage, setCurrentPage] = useState(1);
    const itemsPerPage = 10;
    const totalPages = Math.ceil(enterprises.length / itemsPerPage);

    const startIndex = (currentPage - 1) * itemsPerPage;
    const currentEnterprises = enterprises.slice(
        startIndex,
        startIndex + itemsPerPage
    );

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Entreprises" />

            <div className="p-6 my-3 border">
                <div className="flex justify-between items-center mb-6">
                    <div className="flex items-center space-x-4">
                        <div className="relative">
                            <Search className="absolute left-3 top-1/2 w-4 h-4 text-gray-400 -translate-y-1/2" />
                            <input
                                type="text"
                                placeholder="Rechercher une entreprise"
                                className="py-2 pr-4 pl-9 rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            />
                        </div>
                    </div>
                    <div className="flex items-center space-x-2">
                        <button className="flex items-center px-4 py-2 space-x-2 font-semibold text-white bg-blue-600 rounded-lg shadow-sm transition-colors duration-200 hover:bg-blue-700">
                            <Plus className="w-5 h-5" />
                            <span>Ajouter une nouvelle entreprise</span>
                        </button>
                        <button className="flex items-center px-4 py-2 space-x-2 font-semibold text-gray-600 rounded-lg border border-gray-300 shadow-sm transition-colors duration-200 hover:bg-gray-100">
                            <Filter className="w-5 h-5" />
                            <span>Filtre</span>
                        </button>
                    </div>
                </div>

                {/* Table */}
                <div className="overflow-hidden">
                    <table className="w-full text-sm text-left text-gray-500">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">
                                    Nom entreprise
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    ID entreprise
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Secteur
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Localisation
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Type
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {currentEnterprises.map((enterprise, index) => (
                                <tr
                                    key={enterprise.id}
                                    className={`${
                                        index % 2 === 0
                                            ? "bg-white"
                                            : "bg-gray-50"
                                    } hover:bg-gray-100 transition-colors duration-200`}
                                >
                                    <td className="flex items-center px-6 py-4 space-x-3">
                                        <img
                                            src={enterprise.photo}
                                            alt={enterprise.name}
                                            className="w-8 h-8 rounded-full"
                                        />
                                        <span className="font-medium text-gray-800">
                                            {enterprise.name}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {enterprise.enterpriseId}
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {enterprise.sector}
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {enterprise.location}
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {enterprise.type}
                                    </td>
                                    <td className="px-6 py-4">
                                        <span className="bg-blue-100 text-blue-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {enterprise.status}
                                        </span>
                                    </td>
                                    <td className="px-6 py-4 space-x-2">
                                        <button className="text-gray-400 transition-colors hover:text-gray-700">
                                            <Eye className="w-5 h-5" />
                                        </button>
                                        <button className="text-gray-400 transition-colors hover:text-gray-700">
                                            <Pencil className="w-5 h-5" />
                                        </button>
                                        <button className="text-gray-400 transition-colors hover:text-gray-700">
                                            <Trash2 className="w-5 h-5" />
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                <div className="flex justify-between items-center mt-6 text-sm text-gray-500">
                    <div className="flex items-center space-x-2">
                        <span className="text-gray-500">Présentation</span>
                        <select className="p-1 text-gray-500 rounded-lg border border-gray-300">
                            <option>10</option>
                        </select>
                    </div>
                    <div className="flex items-center space-x-4">
                        <span className="text-gray-500">
                            Affichage de {startIndex + 1} à{" "}
                            {Math.min(
                                startIndex + itemsPerPage,
                                enterprises.length
                            )}{" "}
                            sur {enterprises.length} enregistrements
                        </span>
                        <div className="flex items-center space-x-1">
                            <button
                                onClick={() =>
                                    setCurrentPage((prev) =>
                                        Math.max(prev - 1, 1)
                                    )
                                }
                                disabled={currentPage === 1}
                                className={`p-2 rounded-lg border border-gray-300 ${
                                    currentPage === 1
                                        ? "text-gray-300"
                                        : "text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                }`}
                            >
                                <ChevronLeft className="w-4 h-4" />
                            </button>
                            {Array.from({ length: totalPages }, (_, i) => (
                                <button
                                    key={i + 1}
                                    onClick={() => setCurrentPage(i + 1)}
                                    className={`px-3 py-1 rounded-lg border border-gray-300 ${
                                        currentPage === i + 1
                                            ? "bg-blue-600 text-white"
                                            : "bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                    }`}
                                >
                                    {i + 1}
                                </button>
                            ))}
                            <button
                                onClick={() =>
                                    setCurrentPage((prev) =>
                                        Math.min(prev + 1, totalPages)
                                    )
                                }
                                disabled={currentPage === totalPages}
                                className={`p-2 rounded-lg border border-gray-300 ${
                                    currentPage === totalPages
                                        ? "text-gray-300"
                                        : "text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                }`}
                            >
                                <ChevronRight className="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
