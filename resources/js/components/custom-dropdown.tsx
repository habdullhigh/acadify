import { useState } from "react";

type OptionType = {
    label: string;
    value: string | number;
};

type CustomDropdownProps = {
    options: OptionType[];
    placeholder?: string;
    onChange?: (value: string | number) => void;
    fontHeavy?: boolean;
    minWidth?: string | number;
    value?: string | number;
};

const CustomDropdown: React.FC<CustomDropdownProps> = ({
    options,    
    placeholder = "Select an option",
    onChange,
    fontHeavy = false,
    minWidth = "150px",
    value,
}) => {
    const [isOpen, setIsOpen] = useState(false);
    const selectedOption = options.find((opt) => opt.value === value);

    const toggleDropdown = () => setIsOpen((prev) => !prev);

    const handleOptionClick = (option: OptionType) => {
        setIsOpen(false);
        if (onChange) onChange(option.value);
    };

    return (
        <div style={{ minWidth }} className="relative">
            <button
                onClick={toggleDropdown}
                className={`w-full p-2 relative z-[15] text-sm text-[#101828] flex items-center justify-between bg-[#D1E0FF] border-2 border-[#84ADFF] rounded-xl ${
                    fontHeavy ? "font-bold" : "font-normal"
                } focus:outline-none focus:ring-0`}
            >
                <div>
                    {selectedOption
                        ? selectedOption.label
                        : placeholder || options[0]?.label}
                </div>
                <img src="/icons/custom-dropdown-caret.svg" alt="caret" />
            </button>
            {isOpen && (
                <div className="flex items-center justify-center p-1 pt-4 absolute w-full z-10 -mt-3 bg-[#84ADFF] rounded-b-xl">
                    <ul className="flex flex-col gap-2 items-center w-full">
                        {options.map((option) => (
                            <li
                                key={option.value}
                                className="flex items-center justify-between w-full text-[#344054] bg-[#B2CCFF33] rounded-xl p-2 text-sm cursor-pointer hover:bg-[#B2CCFF55]"
                                onClick={() => handleOptionClick(option)}
                            >
                                <span>{option.label}</span>
                                {selectedOption?.value === option.value && (
                                    <img
                                        src="/icons/custom-dropdown-check.svg"
                                        alt="Selected"
                                    />
                                )}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
};

export default CustomDropdown;
