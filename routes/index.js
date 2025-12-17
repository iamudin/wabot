const from: string =
  [
    message.key.remoteJidAlt,
    message.key.remoteJid,
  ]
    .filter((jid): jid is string => typeof jid === "string")
    .map(jid => jid.replace(/@.+$/, ""))
    .find(num => num.startsWith("62")) ?? "";