import { Search, Filter, Pencil } from "lucide-react";
import StatusBadge from "@/Components/StatusBadge";

export default function EmployeeList({ employees }) {
    return (
        <div className="w-full">
            <div className="flex justify-between items-center mb-6">
                <div className="flex items-center space-x-4">
                    <div className="relative">
                        <Search className="absolute left-3 top-1/2 w-4 h-4 text-gray-400 -translate-y-1/2" />
                        <input
                            type="text"
                            placeholder="Rechercher un employé"
                            className="py-2 pr-4 pl-9 rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>
                </div>
                <div className="flex items-center space-x-2">
                    <button className="flex items-center px-4 py-2 space-x-2 font-semibold text-gray-600 rounded-lg border border-gray-300 shadow-sm transition-colors duration-200 hover:bg-gray-100">
                        <Filter className="w-5 h-5" />
                        <span>Filtre</span>
                    </button>
                </div>
            </div>

            {/* Table */}
            <div className="overflow-hidden bg-white rounded-lg border border-gray-200">
                {employees && employees.length > 0 ? (
                    <table className="w-full text-sm text-left text-gray-500">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">
                                    Employé
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Matricule
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Département
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Poste
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {employees.map((employee, index) => (
                                <tr
                                    key={employee.id}
                                    className={`${
                                        index % 2 === 0
                                            ? "bg-white"
                                            : "bg-gray-50"
                                    } hover:bg-gray-100 transition-colors duration-200`}
                                >
                                    <td className="flex items-center px-6 py-4 space-x-3">
                                        {employee.photo ? (
                                            <img
                                                src={employee.photo}
                                                alt={`${employee.first_name} ${employee.last_name}`}
                                                className="object-cover w-8 h-8 rounded-full"
                                            />
                                        ) : (
                                            <div className="flex justify-center items-center w-8 h-8 text-xs font-medium text-white bg-blue-500 rounded-full">
                                                {employee.user.first_name
                                                    ? employee.user.first_name
                                                          .charAt(0)
                                                          .toUpperCase()
                                                    : "E"}
                                            </div>
                                        )}
                                        <div>
                                            <span className="font-medium text-gray-800">
                                                {employee.user.first_name}{" "}
                                                {employee.user.last_name}
                                            </span>
                                            <div className="text-xs text-gray-500">
                                                {employee.user.email}
                                            </div>
                                        </div>
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {employee.code || "-"}
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {employee.department?.name || "-"}
                                    </td>
                                    <td className="px-6 py-4 text-gray-500">
                                        {employee.role || "-"}
                                    </td>
                                    <td className="px-6 py-4">
                                        <StatusBadge
                                            status={
                                                employee.status || "inactive"
                                            }
                                            size="sm"
                                        />
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
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                />
                            </svg>
                        </div>
                        <h3 className="mb-2 text-lg font-medium text-gray-900">
                            Aucun employé trouvé
                        </h3>
                        <p className="mb-6 text-gray-500">
                            Il n'y a actuellement aucun employé enregistré dans
                            cette entreprise.
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
}
