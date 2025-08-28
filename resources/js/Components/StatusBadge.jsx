import { CheckCircle, X, Clock, Ban } from "lucide-react";

// Status configuration mapping - based on Enterprise model statuses
const statusConfig = {
    pending: {
        label: "En attente",
        bgColor: "bg-amber-500/10",
        borderColor: "border-amber-500/20",
        textColor: "text-amber-600",
        icon: Clock,
        iconColor: "text-amber-600",
    },
    active: {
        label: "Actif",
        bgColor: "bg-emerald-500/10",
        borderColor: "border-emerald-500/20",
        textColor: "text-emerald-600",
        icon: CheckCircle,
        iconColor: "text-emerald-600",
    },
    inactive: {
        label: "Inactif",
        bgColor: "bg-orange-500/10",
        borderColor: "border-orange-500/20",
        textColor: "text-orange-600",
        icon: X,
        iconColor: "text-orange-600",
    },
    suspended: {
        label: "Suspendu",
        bgColor: "bg-red-500/10",
        borderColor: "border-red-500/20",
        textColor: "text-red-600",
        icon: Ban,
        iconColor: "text-red-600",
    },
};

export default function StatusBadge({
    status,
    showLabel = true,
    size = "default",
    variant = "default",
    filled = false,
}) {
    // Get status configuration or use default
    const config = statusConfig[status] || statusConfig.inactive;
    const IconComponent = config.icon;

    // Size variants
    const sizeClasses = {
        sm: "px-2 py-1 text-xs",
        default: "px-3 py-1.5 text-sm",
        lg: "px-4 py-2 text-base",
    };

    // Background style based on filled prop
    const getBackgroundStyle = () => {
        if (filled) {
            // Full background
            return `${config.bgColor.replace(
                "/10",
                ""
            )} ${config.borderColor.replace("/20", "")} text-white`;
        } else {
            // Soft background
            return `${config.bgColor} ${config.borderColor} ${config.textColor}`;
        }
    };

    // Variant styles
    const variantClasses = {
        default: `inline-flex items-center gap-2 rounded-full font-medium border ${getBackgroundStyle()}`,
        outline: `inline-flex items-center gap-2 rounded-full font-medium border ${config.borderColor} ${config.textColor}`,
        solid: `inline-flex items-center gap-2 rounded-full font-medium text-white ${config.bgColor.replace(
            "/10",
            ""
        )} border ${config.borderColor.replace("/20", "")}`,
    };

    return (
        <div className={`${variantClasses[variant]} ${sizeClasses[size]}`}>
            <IconComponent
                className={`h-4 w-4 ${
                    filled ? "text-white" : config.iconColor
                }`}
            />
            {showLabel && <span>{config.label}</span>}
        </div>
    );
}

// Export the status configuration for external use
export { statusConfig };
