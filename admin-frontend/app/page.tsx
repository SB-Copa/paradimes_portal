import SelectTables from "@/components/layout/test/select-tables";
import Image from "next/image";

export default function Home() {
  return (
    <div className="flex items-center justify-center">
      <h1>PD Admin</h1>

      <SelectTables />
    </div>
  );
}
