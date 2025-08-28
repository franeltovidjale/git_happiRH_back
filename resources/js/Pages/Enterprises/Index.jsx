import { Head } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Search, Plus, Filter, Eye, Pencil, Trash2 } from "lucide-react";
import { Link } from "@inertiajs/react";
import StatusBadge from "@/Components/StatusBadge";

export default function EnterprisesIndex({ auth, enterprises }) {
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
                    {enterprises.data.length > 0 ? (
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
                                        Pays
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
                                {enterprises.data.map((enterprise, index) => (
                                    <tr
                                        key={enterprise.id}
                                        className={`${
                                            index % 2 === 0
                                                ? "bg-white"
                                                : "bg-gray-50"
                                        } hover:bg-gray-100 transition-colors duration-200`}
                                    >
                                        <td className="flex items-center px-6 py-4 space-x-3">
                                            {enterprise.logo ? (
                                                <img
                                                    src={enterprise.logo}
                                                    alt={enterprise.name}
                                                    className="object-cover w-8 h-8 rounded-full"
                                                />
                                            ) : (
                                                <div className="flex justify-center items-center w-8 h-8 text-xs font-medium text-white bg-blue-500 rounded-full">
                                                    {enterprise.name
                                                        .charAt(0)
                                                        .toUpperCase()}
                                                </div>
                                            )}
                                            <span className="font-medium text-gray-800">
                                                {enterprise.name}
                                                {enterprise.plan && (
                                                    <>
                                                        {" "}
                                                        <br />{" "}
                                                        <span className="text-xs text-gray-400">
                                                            Plan: ({" "}
                                                            <span className="text-teal-500">
                                                                Free
                                                            </span>
                                                            )
                                                        </span>{" "}
                                                    </>
                                                )}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-gray-500">
                                            {enterprise.code}
                                        </td>
                                        <td className="px-6 py-4 text-gray-500">
                                            {enterprise.sector?.name || "-"}
                                        </td>
                                        <td className="px-6 py-4 text-gray-500">
                                            {enterprise.country?.name ||
                                                enterprise.country_code}
                                        </td>
                                        <td className="px-6 py-4">
                                            <StatusBadge
                                                status={enterprise.status}
                                            />
                                        </td>
                                        <td className="px-6 py-4 space-x-2">
                                            <Link
                                                href={route(
                                                    "enterprises.show",
                                                    enterprise.id
                                                )}
                                                className="text-gray-400 transition-colors hover:text-gray-700"
                                            >
                                                <Eye className="w-5 h-5" />
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    ) : (
                        <div className="py-12 text-center">
                            <div className="flex justify-center items-center mx-auto mb-4 w-24 h-24 bg-gray-100 rounded-full">
                                <svg
                                    className="w-12 h-12 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                    />
                                </svg>
                            </div>
                            <h3 className="mb-2 text-lg font-medium text-gray-900">
                                Aucune entreprise trouvée
                            </h3>
                            <p className="mb-6 text-gray-500">
                                Il n'y a actuellement aucune entreprise
                                enregistrée dans le système.
                            </p>
                            <button className="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded-lg transition-colors hover:bg-blue-700">
                                <Plus className="mr-2 w-5 h-5" />
                                Ajouter une entreprise
                            </button>
                        </div>
                    )}
                </div>

                {/* Pagination */}
                {enterprises.links && enterprises.links.length > 3 && (
                    <div className="flex justify-between items-center mt-6 text-sm text-gray-500">
                        <div className="flex items-center space-x-2">
                            <span className="text-gray-500">Présentation</span>
                            <select className="p-1 text-gray-500 rounded-lg border border-gray-300">
                                <option>10</option>
                            </select>
                        </div>
                        <div className="flex items-center space-x-4">
                            <span className="text-gray-500">
                                Affichage de {enterprises.from} à{" "}
                                {enterprises.to} sur {enterprises.total}{" "}
                                enregistrements
                            </span>
                            <div className="flex items-center space-x-1">
                                {enterprises.links.map((link, index) => (
                                    <a
                                        key={index}
                                        href={link.url}
                                        className={`px-3 py-1 rounded-lg border border-gray-300 ${
                                            link.active
                                                ? "bg-blue-600 text-white"
                                                : link.url
                                                ? "bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                                : "bg-gray-100 text-gray-300 cursor-not-allowed"
                                        }`}
                                        dangerouslySetInnerHTML={{
                                            __html: link.label,
                                        }}
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
