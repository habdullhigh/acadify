import { SharedData } from '@/types';
import { router, usePage } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

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
    type?: 'Form' | 'Reciept';
}

const statusColorMap: Record<FormStatus, string> = {
    approved: 'text-green-600',
    rejected: 'text-red-600',
    pending: 'text-yellow-600',
};

const rejectionReasons = ['Incomplete document', 'Incorrect format', 'Missing signature', 'Not within submission period'];

export default function FormCard({ type, id, title, status, description, created, link, rejectionReason, target_office }: FormCardProps) {
    const { auth } = usePage<SharedData>().props;
    const userType = auth.user?.user_type;
    const [showRejectOptions, setShowRejectOptions] = useState(false);
    const [selectedReason, setSelectedReason] = useState('');
    const [offices, setOffices] = useState<{ label: string; value: string | number }[]>([]);
    const getOfficeIdFromLabel = (label: string): number | undefined => {
        const match = offices.find((office) => office.label === label);
        return match ? Number(match.value) : undefined;
    };
    const targetOfficeId = getOfficeIdFromLabel(target_office);
    const isAdminAndOwner = userType === 'admin' && status === 'pending' && auth.user?.office_id === targetOfficeId;

    useEffect(() => {
        const fetchOffices = async () => {
            try {
                const response = await axios.get('/offices');
                const formatted = response.data.map((office: any) => ({
                    label: office.name,
                    value: office.id,
                }));
                setOffices(formatted);
            } catch (error) {
                console.error('Error fetching offices:', error);
            }
        };

        fetchOffices();
    }, []);

    const handleAccept = async () => {
        try {
            await axios.post(route('submissions.accept'), {
                submission_id: id,
                type: type.toLowerCase(), // 'form' or 'receipt'
            });
            alert('Submission accepted successfully');
            router.reload(); // Reload the page to reflect changes
        } catch (error) {
            console.error('Error accepting:', error);
            alert('An error occurred while accepting.');
        }
    };

    const handleReject = () => {
        setShowRejectOptions(true);
    };

    const submitRejection = async () => {
        if (!selectedReason) {
            alert('Please select a reason for rejection');
            return;
        }

        try {
            await axios.post(route('submissions.reject'), {
                submission_id: id,
                type: type.toLowerCase(),
                rejection_reason: selectedReason,
            });
            setShowRejectOptions(false);
            alert('Submission Rejected');
            router.reload(); // Reload the page to reflect changes
        } catch (error) {
            console.error('Error rejecting:', error);
            alert('An error occurred while rejecting.');
        }
    };

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
                    View Uploaded {type === 'Form' ? 'Form' : 'Reciept'}
                </a>
            </div>
            {isAdminAndOwner && (
                <div className="mt-4 space-x-2">
                    <button onClick={handleAccept} className="rounded-md bg-green-600 px-4 py-1 text-white">
                        Accept
                    </button>
                    <button onClick={handleReject} className="rounded-md bg-red-600 px-4 py-1 text-white">
                        Reject
                    </button>
                </div>
            )}

            {showRejectOptions && (
                <div className="mt-3 space-y-2">
                    <select className="w-full rounded-md border px-2 py-1" value={selectedReason} onChange={(e) => setSelectedReason(e.target.value)}>
                        <option value="">Select rejection reason</option>
                        {rejectionReasons.map((reason) => (
                            <option key={reason} value={reason}>
                                {reason}
                            </option>
                        ))}
                    </select>
                    <button onClick={submitRejection} className="rounded-md bg-red-500 px-4 py-1 text-white">
                        Submit Rejection
                    </button>
                </div>
            )}
        </div>
    );
}
