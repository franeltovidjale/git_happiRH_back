import { Users } from "lucide-react";
import {
    BarChart,
    Bar,
    XAxis,
    YAxis,
    Tooltip,
    ResponsiveContainer,
} from "recharts";

// Données factices pour le graphique
const data = [
    { name: "10 AM", visits: 220 },
    { name: "12 PM", visits: 310 },
    { name: "2 PM", visits: 400 },
    { name: "4 PM", visits: 470 },
    { name: "6 PM", visits: 430 },
    { name: "8 PM", visits: 425 },
    { name: "10 PM", visits: 360 },
    { name: "12 AM", visits: 590 },
    { name: "2 AM", visits: 520 },
    { name: "4 AM", visits: 480 },
    { name: "6 AM", visits: 370 },
    { name: "8 AM", visits: 500 },
];

export default function VisitsChart() {
    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            const value = payload[0].value;
            const time = label;
            const date = "Lundi, 18 Septembre"; // Données statiques pour l'exemple
            return (
                <div className="p-4 text-sm bg-white rounded-lg border border-gray-200 shadow-md">
                    <p className="font-bold text-gray-800">{`${value} Visites`}</p>
                    <p className="text-gray-500">{time}</p>
                    <p className="text-gray-500">{date}</p>
                </div>
            );
        }
        return null;
    };

    return (
        <div className="flex gap-6">
            {/* Graphique - 9/12 */}
            <div className="flex-1 p-6 bg-white rounded-3xl border border-gray-200 shadow-md">
                <div className="flex justify-between items-center mb-4">
                    <div className="flex items-center space-x-2">
                        <Users className="w-5 h-5 text-gray-500" />
                        <h2 className="text-lg font-semibold text-gray-800">
                            Visites dans le temps
                        </h2>
                    </div>
                    <span className="text-sm font-semibold text-green-500">
                        En croissance
                    </span>
                </div>
                <div style={{ width: "100%", height: 300 }}>
                    <ResponsiveContainer>
                        <BarChart data={data}>
                            <defs>
                                <linearGradient
                                    id="colorGradient"
                                    x1="0"
                                    y1="0"
                                    x2="0"
                                    y2="1"
                                >
                                    <stop
                                        offset="0%"
                                        stopColor="#FB6F3C"
                                        stopOpacity={0.8}
                                    />
                                    <stop
                                        offset="100%"
                                        stopColor="#FEAD59"
                                        stopOpacity={0.1}
                                    />
                                </linearGradient>
                            </defs>
                            <XAxis
                                dataKey="name"
                                axisLine={false}
                                tickLine={false}
                                tick={{
                                    fill: "#6B7280",
                                    fontSize: 12,
                                    fontWeight: "medium",
                                }}
                            />
                            <YAxis
                                axisLine={false}
                                tickLine={false}
                                tick={{
                                    fill: "#6B7280",
                                    fontSize: 12,
                                    fontWeight: "medium",
                                }}
                            />
                            <Tooltip content={<CustomTooltip />} />
                            <Bar
                                dataKey="visits"
                                fill="url(#colorGradient)"
                                radius={[10, 10, 0, 0]}
                                barSize={12}
                                className="transition-colors hover:fill-orange-500"
                            />
                        </BarChart>
                    </ResponsiveContainer>
                </div>
            </div>

            {/* Widget Top Pages Views - 3/12 */}
            <div className="p-6 w-80 bg-white rounded-3xl border border-gray-200 shadow-md">
                <div className="flex items-center mb-4 space-x-2">
                    <div className="p-2 bg-gradient-to-br rounded-lg from-primary to-primary-600">
                        <Users className="w-4 h-4 text-white" />
                    </div>
                    <h2 className="text-lg font-semibold text-gray-800">
                        Entreprises
                    </h2>
                </div>

                <div className="space-y-4">
                    {/* Entreprises Actives */}
                    <div className="space-y-2">
                        <div className="flex justify-between items-center">
                            <span className="text-sm font-medium text-gray-800">
                                Entreprises actives
                            </span>
                            <span className="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">
                                125
                            </span>
                        </div>
                        <div className="overflow-hidden relative h-4 bg-gray-100 rounded-full">
                            <div
                                className="absolute top-0 left-0 h-full bg-gradient-to-r rounded-full transition-all duration-300 from-primary to-primary-600"
                                style={{ width: "80%" }}
                            ></div>
                        </div>
                    </div>

                    {/* Entreprises Pending Review */}
                    <div className="space-y-2">
                        <div className="flex justify-between items-center">
                            <span className="text-sm font-medium text-gray-800">
                                Pending review
                            </span>
                            <span className="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">
                                8
                            </span>
                        </div>
                        <div className="overflow-hidden relative h-4 bg-gray-100 rounded-full">
                            <div
                                className="absolute top-0 left-0 h-full bg-gradient-to-r rounded-full transition-all duration-300 from-primary to-primary-600"
                                style={{ width: "5%" }}
                            ></div>
                        </div>
                    </div>

                    {/* Entreprises Inactives */}
                    <div className="space-y-2">
                        <div className="flex justify-between items-center">
                            <span className="text-sm font-medium text-gray-800">
                                Inactives
                            </span>
                            <span className="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">
                                16
                            </span>
                        </div>
                        <div className="overflow-hidden relative h-4 bg-gray-100 rounded-full">
                            <div
                                className="absolute top-0 left-0 h-full bg-gradient-to-r rounded-full transition-all duration-300 from-primary to-primary-600"
                                style={{ width: "10%" }}
                            ></div>
                        </div>
                    </div>

                    {/* Entreprises Suspendues */}
                    <div className="space-y-2">
                        <div className="flex justify-between items-center">
                            <span className="text-sm font-medium text-gray-800">
                                Suspendues
                            </span>
                            <span className="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">
                                8
                            </span>
                        </div>
                        <div className="overflow-hidden relative h-4 bg-gray-100 rounded-full">
                            <div
                                className="absolute top-0 left-0 h-full bg-gradient-to-r rounded-full transition-all duration-300 from-primary to-primary-600"
                                style={{ width: "5%" }}
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
