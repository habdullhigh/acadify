import React from 'react';

interface UploadButtonProps {
    onFileSelect: (file: File) => void;
    acceptedTypes?: string;
    label?: string;
    id?: string;
    className?: string;
}

const UploadButton: React.FC<UploadButtonProps> = ({
    onFileSelect,
    acceptedTypes = '.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx',
    label = 'Choose File',
    id = 'upload-file',
    className = '',
}) => {
    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            onFileSelect(file);
        }
    };

    return (
        <div className="flex flex-col">
            <input
                type="file"
                id={id}
                accept={acceptedTypes}
                className="hidden"
                onChange={handleFileChange}
            />
            <label
                htmlFor={id}
                className={`cursor-pointer rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 transition-colors duration-200 text-center w-fit ${className}`}
            >
                {label}
            </label>
        </div>
    );
};

export default UploadButton;
