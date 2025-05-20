type FormStatus = 'pending' | 'approved' | 'rejected';

interface FormCardProps {
    id: number;
    title: string;
    status: FormStatus;
    description: string;
    created: string; // ISO date
    link: string;
    target_office: string;
    rejectionReason?: string;
}

const statusColorMap: Record<FormStatus, string> = {
    approved: 'text-green-600',
    rejected: 'text-red-600',
    pending: 'text-yellow-600',
};

export default function FormCard({ id, title, status, description, created, link, rejectionReason,target_office }: FormCardProps) {
    return (
        <div className="">
            <div className="text-sm">
                <span className="font-semibold">Status:</span> <span className={`font-bold ${statusColorMap[status]}`}>{status.toUpperCase()}</span>
            </div>

            {status === 'rejected' && rejectionReason && (
                <div className="text-sm text-red-500">
                    <span className="font-semibold">Rejection Reason:</span> {rejectionReason}
                </div>
            )}

            <div className="text-sm">
                <span className="font-semibold">Title:</span> {title.replace(/_/g, ' ')}
            </div>

            <div className="text-sm">
                <span className="font-semibold">Form ID:</span> #{id}
            </div>

            <div className="text-sm">
                <span className="font-semibold">Submitted:</span> {new Date(created).toLocaleDateString()}
            </div>

            <div className="text-sm">
                <span className="font-semibold">Description:</span> {description}
            </div>
            <div className="text-sm">
                <span className="font-semibold">Target Office:</span> {target_office}
            </div>

            <div className="mt-2">
                <a href={link} target="_blank" rel="noopener noreferrer" className="text-sm text-blue-600 underline">
                    View Uploaded Form
                </a>
            </div>
        </div>
    );
}
