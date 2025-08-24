import { Info, TrendingUp } from "lucide-react";

export default function MetricCard({
    icon: Icon,
    title,
    reachText,
    percentage,
    primaryValue,
    primaryLabel,
    secondaryValue,
    secondaryLabel,
}) {
    return (
        <div className="p-4 bg-white rounded-lg border border-gray-100">
            <div className="flex justify-between items-center mb-3">
                <div className="flex items-center space-x-2">
                    <div className="p-2 bg-gradient-to-br rounded-lg from-primary-400 to-primary-600">
                        <Icon className="w-4 h-4 text-white" />
                    </div>
                    <div className="flex items-center space-x-1">
                        <span className="text-sm font-semibold text-gray-800">
                            {title}
                        </span>
                        <Info className="w-3 h-3 text-gray-400" />
                    </div>
                </div>
            </div>
            <div className="flex justify-between items-center mb-2">
                <span className="text-xs text-gray-500">{reachText}</span>
                <div className="flex items-center px-2 py-1 space-x-1 rounded-full bg-custom-green">
                    <TrendingUp className="w-3 h-3 text-white" />
                    <span className="text-xs font-medium text-white">
                        {percentage}
                    </span>
                </div>
            </div>
            <hr className="my-3 border-gray-200" />
            <div className="flex justify-between">
                <div className="text-center">
                    <div className="text-lg font-bold text-gray-800">
                        {primaryValue}
                    </div>
                    <div className="text-xs text-gray-500">{primaryLabel}</div>
                </div>
                {secondaryValue && (
                    <div className="text-center">
                        <div className="text-lg font-bold text-gray-800">
                            {secondaryValue}
                        </div>
                        <div className="text-xs text-gray-500">
                            {secondaryLabel}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
